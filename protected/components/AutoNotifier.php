<?php

class AutoNotifier {

    static function addFirmNotifier( int $idFirm, array $param = array() )
    {
        $firm = CatalogFirms::fetch( $idFirm );
        if( $firm->id >0 )
        {
            /*
                    Типы рекомендаций:
                      - по заполнению
                      -  - заполненные поля
                      -  - по объему заполненности полей
                      - -  Обязательно по цене`
                      -  - наличие картинок

                      -  добавьте также туры для других стран ( а вы знали что самым популярным местом для туризма в Малайзию )
             */
            $itemParam = array();
            $itemParam["recomFields"] = array( "name", "description", "country_id", "image", "email", "www", "tel", "address" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 0;
            self::objectCheck( $firm, $itemParam );
        }
    }

    static function objectCheck( CCModel $objectModel, array $param )
    {
        /*
            $itemParam["recomFields"] = array( "name", "description", "country_id", "image", "email", "www", "tel", "address" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 0;
         */

        $cout = "";

        // Определяем рекоменадции по
        if( sizeof( $param["recomFields"] ) >0 )
        {
            $recommendation = "";
            foreach( $param["recomFields"] as $field )
            {
                if( !$objectModel->$field )
                    if( !empty( $objectModel->attributeLabels[ $field ] ) )$recommendation .= "<li>".$objectModel->attributeLabels[ $field ]."</li>";
                                                                      else $recommendation .= "<li>".$field."</li>";
            }

            if( !empty( $recommendation ) )
            {
                $cout .= "<h3>Рекомендации по количеству заполненных полей</h3><p>Для привлечения максимального количества клентов мы советуем Вам заполнить следующие поля: <ul>".$recommendation."</ul> <br/> <b>Внимание!!!</b>Данные именно этих полей анализируются, для того чтобы определить позицию объявления в поиске. И соответсвенно чем качественнее Вы заполните указанные поля, тем лучшую позицию сможет занять Ваше объявление. </p>";
            }
        }


        //  Проверяем размероность полей
        if( sizeof( $param["recomSizeFields"] ) >0 )
        {
            $recommendationSize = "";
            foreach( $param["recomSizeFields"] as $field )
            {
                $fieldValue = trim( strip_tags( $objectModel->$field ) );
                if( !empty( $param["recomSizeFields"][$field] ) && $objectModel->$field && strlen($fieldValue ) < $param["recomSizeFields"][$field] )
                {
                    $fieldName = !empty( $objectModel->attributeLabels[ $field ] ) ? $objectModel->attributeLabels[ $field ] : $field;
                    $recommendationSize .= "<li>Для поля" . $fieldName . " мы рекомендуем размер - ".$param["recomSizeFields"][$field]." знаков, а Вы указали только ".strlen($fieldValue )." знаков </li>";
                }
            }
            if( !empty( $recommendationSize ) )
            {
                $cout .= "<h3>Рекомендации по качеству заполненных полей</h3><p>Мы про анализировалии введенные Вами данные, на основании этого рекомендуем Вам внести следующие корректировки:
<ul>".$recommendationSize."</ul></p>";
            }
        }

        // Если указанны рекомендации по количеству картинок
        if( (int) $param["image_count"] > 0 )
        {
            $count = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("item_id=:fid AND catalog=:catalog")->setParams( array( ":fid"=>$objectModel->id, $objectModel->tableName() ) ) );
            if( $count<$param["image_count"] )
            {
                $cout .= "<h3>Рекомендации по количеству картинок</h3>";
                if( $count == 0 )$cout .= "<p>Вы не загрузили не одной фотографии для Вашего объявления - так не пойдет.<br/>
Если Вы действительно хотите привлечь внимание к своему объвлению то Вам необходимо добавить картинки к своему объявлению.<br/>
Мы рекомендуем Вам добавить: : ".$param["image_count"]." фото</p>";

                if( $count >0 )$cout .= "<p>Вы загрузили всего ".$count." фото, а что больше нет?<br/>Чем больше фото вы загрузите тем лехче заинтересовать пользователя в Ваших услугах. Именно поэтому мы рекомендуем минимум ".$param["image_count"]." фото, а максимум 10 фото.</p>";
            }
        }

        return $cout;
    }
}