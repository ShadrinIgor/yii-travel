<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 06.02.13
 * Time: 18:32
 * To change this template use File | Settings | File Templates.
 */
class s_subscribe
{
    public $list = array();

    static function create(){return new s_subscribe();}

    public function getList( $conditional = "" )
    {
        $query = "SELECT * FROM sb_subscribe".( !empty( $conditional ) ? "WHERE ".$conditional : "" );
        $res = mysql_query( $query ) or die( mysql_error() );
        while( $line = mysql_fetch_array( $res ) )
        {
            $this->list[] = m_subscribe::fromArray( $line );
        }

        return $this->list;
    }

    public function getByID( $id )
    {
        $query = "SELECT * FROM sb_subscribe WHERE id=".$id;
        $res = mysql_query( $query );
        if( mysql_num_rows( $res )>0 )
        {
            $line = mysql_fetch_array( $res  );
            if( $line["id"]>0 )return m_subscribe::fromArray( $line );
        }

        return false;
    }

    public function save( m_subscribe $model )
    {
        $model->subject = addslashes( $model->subject );
        $model->message = addslashes( $model->message );
        if( $model->id >0 )
        {
            $query = "UPDATE sb_subscribe SET `subject`='".$model->subject."', `message`='".$model->message."', `from`='".$model->from."', `status`='".$model->status."', `sender_type`='".$model->sender_type."', `sender_region`='".$model->sender_region."', `sender_list`='".$model->sender_list."' WHERE id='".$model->id."'";
        }
            else
        {
            list( $exists ) = mysql_fetch_array( mysql_query( "SELECT id FROM sb_subscribe WHERE `subject`='".$model->subject."' AND `message`='".$model->message."' AND `from`='".$model->from."'" ) );
            if( empty( $exists ) )
            {
                $query = "INSERT INTO sb_subscribe ( `subject`, `message`, `from`, `date`, `status` , `sender_type` , `sender_region` , `sender_list` ) VALUES( '".$model->subject."','".$model->message."','".$model->from."','".time()."','1','".$model->sender_type."','".$model->sender_region."','".$model->sender_list."' )";
            }
        }

        if( !empty( $query ) )mysql_query( $query ) or die( mysql_error() );
    }

    public function delete( $id )
    {
        $query = "DELETE FROM sb_subscribe WHERE id='".$id."'";
        mysql_query( $query ) or die( mysql_error() );
    }


}
