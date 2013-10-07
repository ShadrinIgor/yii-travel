<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 06.02.13
 * Time: 18:23
 * To change this template use File | Settings | File Templates.
 */
class m_subscribe
{
    public $id;
    public $subject;
    public $message;
    public $from;
    public $date;
    public $status;
    public $sender_type;
    public $sender_region;
    public $sender_list;

    static function create(){return new m_subscribe();}

    static function fromArray( array $data )
    {
        $obj =  new m_subscribe();
        foreach( $data as $key=>$value )
        {
            if( property_exists( $obj, $key ) )
                $obj->$key = $value;
        }

        return $obj;
    }
}
