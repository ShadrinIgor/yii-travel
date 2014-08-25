<?php

class TranslateCommand extends CConsoleCommand
{
    public function run($args)
    {
        $col = 50;
        $n=0;
        //
        $listCatalog = array( "CatalogContent" );//"CatalogTours", "CatalogInfoCategory", "CatalogToursCategory", "CatalogInfo", "CatalogCity", "CatalogFirms", "CatalogHotels", "CatalogKurorts", "CatalogUmor", "CatalogCountry", "CatalogItems", "CatalogItemsCategory", "CatalogContent", "CatalogFirmsItems", "CatalogFirmsService", "CatalogWork" );
        for( $i=0;$i<sizeof( $listCatalog );$i++ )
        {
            $class = $listCatalog[ $i ];
            $list = $class::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("translate=0")->setLimit( $col )->setCache(0) );
            echo $class." - ".$n."( ".sizeof($list)." )<br/>";
            foreach( $list as $model )
            {
                $model->translate = 1;
                if( !$model->save() )print_r( $model->getErrors() );
                    else
                {
                    echo $model->id."<br/>";
                    $n++;
                    $transModel = TranslateHelper::getTranslateModel( $class, $model->id, "en" ); // ja en
                    if( !$transModel->id )
                    {
                        @TranslateHelper::setTranslate( $model, $transModel, "en" );
                    }
                }
            }

            if( sizeof( $list ) == $col || $n >= $col )break;
        }
    }
}