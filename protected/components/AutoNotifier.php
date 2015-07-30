<?php

class AutoNotifier {

    static function addFirmNotifier( int $idFirm, array $param = array() )
    {
        $firm = CatalogFirms::fetch( $idFirm );
        if( $firm->id >0 )
        {
            $itemParam = array();
            $itemParam["recomFields"] = array( "name", "description", "country_id", "image", "email", "www", "tel", "address" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 0;


            /*
                    Типы рекомендаций:
                      - по заполнению
                      -  - заполненные поля
                      -  - по объему заполненности полей
                      - -  Обязательно по цене`
                      -  - наличие картинок

                      -  добавьте также туры для других стран ( а вы знали что самым популярным местом для туризма в Малайзию )
             */



        }
    }

    static function objectCheck( CCModel $objectModel, array $param )
    {
        /*
            $itemParam["recomFields"] = array( "name", "description", "country_id", "image", "email", "www", "tel", "address" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 0;
         */

        $cout = array();

        // Определяем рекоменадции по
        if( sizeof( $param["recomFields"] ) >0 )
        {
            $recommendation = array();
            foreach( $param["recomFields"] as $field )
            {
                if( !$objectModel->$field )
                    if( !empty( $objectModel->attributeLabels[ $field ] ) )$recommendation[] = $objectModel->attributeLabels[ $field ];
                                                                      else $recommendation[] = $field;
            }

            if( sizeof( $recommendation ) >0 )$cout["recommendation"] = $recommendation;
        }

        if( empty( $cout["recommendation"] ) )$cout["recommendation"] = array();

    }
}