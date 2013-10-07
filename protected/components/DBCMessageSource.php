<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 08.10.12
 * To change this template use File | Settings | File Templates.
 */
class DBCMessageSource extends CMessageSource
{
    public function loadmessages( $category, $language)
    {
        // TODO Надо будет доделать сохранение сообщений
        //Yii::app()->db->createCommand( "SELECT * FROM i18n WHERE category='".$category."'" );
    }

    public function translateMessage( $category, $message, $language )
    {
        $result = Yii::app()->db->createCommand()
                                ->select( "b.translation" )
                                ->from( "i18n_translate b" )
                                ->join( "i18n a", "b.id=a.id" )
                                ->where( "a.category=:category AND a.message=:message AND b.language=:language", array( ":category"=>$category, ":message"=>$message, ":language"=>$language ) )
                                ->queryColumn();

        if( !empty( $result[0] ) )return $result[0];
                             else return false;
    }
}
