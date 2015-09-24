<?php

class AutoNotifierAddQueueCommand extends CConsoleCommand
{
    public function run($args)
    {
        $list = array( "catalog_users", "catalog_firms", "catalog_tours", "catalog_firms_service", "catalog_firms_items" );
        for( $i=0;$i<sizeof( $list );$i++ )
        {
            $catalog = SiteHelper::getCamelCase( $list[$i] );
            $listItems = $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("!EXISTS(SELECT id FROM notifications_queue WHERE catalog='".$list[$i]."' AND item_id=".$list[$i]."_as.id)")->setLimit( 50 )->setOrderBy("rating") );
            //$listItems = $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id=13")->setLimit( 100 )->setOrderBy("rating") );

            if( sizeof( $listItems ) >0 )
            {
                foreach( $listItems as $item )
                {
                    $tableName = $item->tableName();
                    switch( $item->tableName() )
                    {
                        case "catalog_users" :
                            if( $item->active == 0 )AutoNotifier::onRegistration( $item );
                                       else
                                   {
                                       $countFirms = CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions( "user_id=:uid" )->setParams( array( ":uid"=>$item->id ) ) );
                                       if( $countFirms ==0 )
                                       {
                                           $tableName = "catalog_users_con";
                                           AutoNotifier::onRegistrationConfirm($item);
                                       }
                                        else continue 2;
                                   }
                        break;
                        case "catalog_firms" : $item->onAddFirm( new CModelEvent( $item ), array( "status"=>"reminder" ) );break;
                        case "catalog_tours" : $item->onAddTour( new CModelEvent( $item ), array( "status"=>"reminder") );break;
                        case "catalog_firms_items" : $item->onAddFirmsItems( new CModelEvent( $item ), array( "status"=>"reminder" ) );break;
                        case "catalog_firms_service" : $item->onAddFirmsService( new CModelEvent( $item ), array( "status"=>"reminder" ) );break;
                        case "catalog_firms_banner" : $item->onAddFirmsBanners( new CModelEvent( $item ), array( "status"=>"reminder" ) );break;
                    }
                    AutoNotifier::addInNotificationsQueue( $tableName, $item->id, 0 );
                }
                return ""                                                                                                                                                                                                                                                                                                                                                                                 ;
            }
        }
    }
}