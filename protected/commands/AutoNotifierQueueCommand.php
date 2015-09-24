<?php

class AutoNotifierQueueCommand extends CConsoleCommand
{
    public function run($args)
    {
        $list = NotificationsQueue::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("date<=:date AND step>-1")->setParams( array(":date"=>time()) )->setLimit(50)->setCache(0) );
        foreach( $list as $item )
        {
            $catalogClass = SiteHelper::getCamelCase( $item->catalog );
            $itemObj = $catalogClass::fetch( $item->item_id );

            if( !$item->step )$item->step=0;
            $step = $item->step < 8 ? $item->step+1 : -1;

            //print_r( $item );
            // Добавляем в очередь на нотификацию
            // В течении 24 часов после добавления или сохранения пользователю приходят уведомления
            // О том что заполнил не полностью, не опубликовал, не добавил картинок и т.д.
            AutoNotifier::addInNotificationsQueue( $item->catalog, $itemObj->id, $step );

            switch( $item->catalog )
            {
                case "catalog_users" : AutoNotifier::onRegistration( $itemObj );break;
                case "catalog_users_con" : AutoNotifier::onRegistrationConfirm( $itemObj );break;
                case "catalog_firms" : $itemObj->onAddFirm( new CModelEvent( $itemObj ), array( "status"=>"reminder" ) );break;
                case "catalog_tours" : $itemObj->onAddTour( new CModelEvent( $itemObj ), array( "status"=>"reminder") );break;
                case "catalog_firms_items" : $itemObj->onAddFirmsItems( new CModelEvent( $itemObj ), array( "status"=>"reminder" ) );break;
                case "catalog_firms_service" : $itemObj->onAddFirmsService( new CModelEvent( $itemObj ), array( "status"=>"reminder" ) );break;
                case "catalog_firms_banner" : $itemObj->onAddFirmsBanners( new CModelEvent( $itemObj ), array( "status"=>"reminder" ) );break;
            }
        }
    }
}