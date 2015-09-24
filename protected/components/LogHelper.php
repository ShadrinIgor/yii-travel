<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 27.09.12
 * Time: 1:20
 * To change this template use File | Settings | File Templates.
 */
class LogHelper
{
    static function save( $type, $id, $action )
    {
        switch( $type )
        {
            case "tours"          : $field = "tour_id";$class="CatLogTours";break;
            case "firms"          : $field = "firm_id";$class="CatLogFirms";break;
            case "hotels"         : $field = "hotel_id";$class="CatLogHotels";break;
            case "resorts"        : $field = "resort_id";$class="CatLogResorts";break;
            case "tours_category" : $field = "cid_id";$class="CatLogToursCategory";break;

        }

        if( !empty($id) && !empty($action) )
        {
            $check = $class::fetchAll( DBQueryParamsClass::CreateParams()->setConditions($field."=:id")->setParams( array( ":id"=>$id ) )->setCache(0) );
            if( sizeof( $check ) >0 )$new = $check[0];
            else
            {
                $new = new $class();
                $new->date_from = time();
            }

            $new->$field = $id;
            $correctAction = false;
            switch( $action )
            {
                case "show"            : $new->action_show ++;$correctAction=true;break;
                case "contact"         : $new->action_contact ++;$correctAction=true;break;
                case "showimage"       : $new->action_showimage ++;$correctAction=true;break;
                case "action_cid_show" : $new->action_cid_show ++;$correctAction=true;break;
                case "action_tor_show" : $new->action_tor_show ++;$correctAction=true;break;
            }

            if( $correctAction )
            {
                if( !$new->save() )print_r( $new->getErrors() );
            }
        }

    }

    static function saveCatLogTours( $tourId )
    {
        // Сохронякем индивидуальный лог
        $check = CatLogTours::findByAttributes( array( "tour_id"=>$tourId, "date2"=>date( "Y-m") ) );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count++;
            $check[0]->save();
        }
            else
        {
            $check = new CatLogTours();
            $check->count = 1;
            $check->tour_id = $tourId;
            $check->date2 = date( "Y-m");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }

        // Сохронякем индивидуальный общий лог
        $check = CatLogToursAll::findByAttributes( array( "date2"=>date( "Y-m-d") ) );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count++;
            $check[0]->save();
        }
        else
        {
            $check = new CatLogToursAll();
            $check->count = 1;
            $check->date2 = date( "Y-m-d");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }
    }

    static function saveCatLogParams( $count_category = 0, $count_country = 0)
    {
        // Сохронякем индивидуальный просмотра категорий
        $check = CatLogToursParams::findByAttributes( array( "date2"=>date( "Y-m-d") ) );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count_category += $count_category;
            $check[0]->count_country += $count_country;
            $check[0]->save();
        }
        else
        {
            $check = new CatLogToursParams();
            $check->count_category += $count_category;
            $check->count_country += $count_country;
            $check->date2 = date( "Y-m-d");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }
    }

    static function saveCatLogCategory( $categoryId )
    {
        // Сохронякем индивидуальный лог по категриям
        $check = CatLogToursCategory::findByAttributes( array( "category_id"=>$categoryId, "date2"=>date( "Y-m") ), 0 );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count++;
            $check[0]->save();
        }
        else
        {
            $check = new CatLogToursCategory();
            $check->count = 1;
            $check->category_id = $categoryId;
            $check->date2 = date( "Y-m");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }
    }


    static function saveCatLogCountry( $countryId )
    {
        // Сохронякем индивидуальный лог по странам
        $check = CatLogToursCountry::findByAttributes( array( "country_id"=>$countryId, "date2"=>date( "Y-m") ), 0 );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count++;
            $check[0]->save();
        }
        else
        {
            $check = new CatLogToursCountry();
            $check->count = 1;
            $check->country_id = $countryId;
            $check->date2 = date( "Y-m");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }
    }

    static function saveCatLogEdit( $count_firm = 0, $count_tours = 0)
    {
        $check = CatLogEdit::findByAttributes( array( "date2"=>date( "Y-m-d") ), 0 );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count_firm += $count_firm;
            $check[0]->count_tours += $count_tours;
            $check[0]->save();
        }
        else
        {
            $check = new CatLogEdit();
            $check->count_firm += $count_firm;
            $check->count_tours += $count_tours;
            $check->date2 = date( "Y-m-d");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }
    }

    static function saveCatLogSubscribe( )
    {
        $check = CatLogSubscribe::findByAttributes( array( "date2"=>date( "Y-m-d") ), 0 );
        if( sizeof( $check ) >0 )
        {
            $check[0]->count ++;
            $check[0]->save();
        }
        else
        {
            $check = new CatLogSubscribe();
            $check->count ++;
            $check->date2 = date( "Y-m-d");
            if( !$check->save() )
                print_r( $check->getErrors() );
        }
    }
}
