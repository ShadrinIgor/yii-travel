<?php

class TranslateCommand extends CConsoleCommand
{
    public function run($args)
    {
        $n=0;
        // "CatalogTours", "CatalogInfoCategory", "CatalogInfo", "CatalogCity",
        $listCatalog = array( "CatalogFirms", "CatalogContent", "CatalogFirmsItems", "CatalogFirmsService", "CatalogHotels", "CatalogItems", "CatalogKurorts", "CatalogUmor", "CatalogWork"  );
        for( $i=0;$i<sizeof( $listCatalog );$i++ )
        {
            $class = $listCatalog[ $i ];
            $list = $class::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("translate=0")->setLimit(10)->setCache(0) );
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

            if( sizeof( $list ) == 10 || $n == 10 )break;
        }
    }
}