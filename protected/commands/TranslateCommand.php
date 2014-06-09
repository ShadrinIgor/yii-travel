<?php

class TranslateCommand extends CConsoleCommand
{
    public function run($args)
    {
        $col = 40;
        $n=0;
        // "CatalogTours", "CatalogInfoCategory", "CatalogInfo", "CatalogCity", "CatalogFirms", "CatalogHotels", "CatalogItems", "CatalogKurorts", "CatalogUmor",
        $listCatalog = array( "CatalogCountry", "CatalogWork", "CatalogContent", "CatalogFirmsItems", "CatalogFirmsService" );
        for( $i=0;$i<sizeof( $listCatalog );$i++ )
        {
            $class = $listCatalog[ $i ];
            $list = $class::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("translate=0")->setLimit( $col )->setCache(0) );
            echo $class." - ".$n."( ".sizeof($list)." )<br/>";
            foreach( $list as $model )
            {
                echo $model->id."<br/>";
                $n++;
                $transModel = TranslateHelper::getTranslateModel( $class, $model->id, "en" );
                if( !$transModel->id )
                {
                    TranslateHelper::setTranslate( $model, $transModel );
                }

                $model->translate = 1;
                if( !$model->save() )
                    print_r( $model->getErrors() );
            }

            if( sizeof( $list ) == $col || $n >= $col )break;
        }
    }
}