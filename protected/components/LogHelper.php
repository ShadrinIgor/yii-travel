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
}
