<?php

class TranslateCommand extends CConsoleCommand
{
    public function run($args)
    {
        $list = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("translate=0")->setLimit(10)->setCache(0) );
        foreach( $list as $model )
        {
            $transModel = TranslateHelper::getTranslateModel( "CatalogTours", $model->id, "en" );
            if( !$transModel->id )
            {
                TranslateHelper::setTranslate( $model, $transModel );
            }

            $model->translate = 1;
            if( !$model->save() )
                print_r( $model->getErrors() );
        }
    }
}