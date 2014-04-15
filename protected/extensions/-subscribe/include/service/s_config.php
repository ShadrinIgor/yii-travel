<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 06.02.13
 * Time: 18:32
 * To change this template use File | Settings | File Templates.
 */
class s_config
{
    public $list = array();

    static function create(){return new s_config();}

    public function getList( $conditional = "" )
    {
        $query = "SELECT * FROM sb_config".( !empty( $conditional ) ? "WHERE ".$conditional : "" );
        $res = mysql_query( $query ) or die( mysql_error() );
        while( $line = mysql_fetch_array( $res ) )
        {
            $this->list[] = m_config::fromArray( $line );
        }

        return $this->list;
    }

    public function getByID( $id )
    {
        $query = "SELECT * FROM sb_config WHERE id=".$id;
        $res = mysql_query( $query );
        if( mysql_num_rows( $res )>0 )
        {
            $line = mysql_fetch_array( $res  );
            if( $line["id"]>0 )return m_config::fromArray( $line );
        }

        return false;
    }

    public function save( m_config $model )
    {
        if( $model->id >0 )
        {
            $query = "UPDATE sb_config SET `key`='".$model->key."', `value`='".$model->value."' WHERE id='".$model->id."'";
        }
            else
        {
            list( $exists ) = mysql_fetch_array( mysql_query( "SELECT id FROM sb_config WHERE `key`='".$model->key."' AND `value`='".$model->value."'" ) );
            if( empty( $exists ) )
            {
                $query = "INSERT INTO sb_config ( `key`, `value` ) VALUES( '".$model->key."','".$model->value."' )";
            }
        }

        if( !empty( $query ) )mysql_query( $query ) or die( mysql_error() );
    }

    public function delete( $id )
    {
        $query = "DELETE FROM sb_config WHERE id='".$id."'";
        mysql_query( $query ) or die( mysql_error() );
    }


}
