<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 06.02.13
 * Time: 18:23
 * To change this template use File | Settings | File Templates.
 */
class m_config
{
    public $id;
    public $key;
    public $value;

    static function create(){return new m_config();}

    static function fromArray( array $data )
    {
        $obj =  new m_config();
        foreach( $data as $key=>$value )
        {
            if( property_exists( $obj, $key ) )
                $obj->$key = $value;
        }

        return $obj;
    }
}
