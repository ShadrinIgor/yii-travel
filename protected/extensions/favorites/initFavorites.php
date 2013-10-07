<?php

/**
 */

class initFavorites extends CApplicationComponent
{
    const ERROR_EMPTY_OBJECT_ID = "error_empty_object_id";
    const ERROR_EMPTY_OBJECT_TYPE = "error_empty_object_type";
    const ERROR_ACCESS = "error_access";
    const ERROR_EXISTS_DATA = "error_exists_data";
    const ERROR_NO_EXISTS_DATA = "error_no_exists_data";

    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.favorites.models.*");
    }

    /*
     * Добавление
     */
    public function add( $object_type, $object_id )
    {
        if( !$this->checkExists( $object_id, $object_type ) )
        {
            $error = $this->checkAccess();
            if( empty( $error ) && empty( $object_id ) )$error = self::ERROR_EMPTY_OBJECT_ID;
            if( empty( $error ) && empty( $object_type ) )$error = self::ERROR_EMPTY_OBJECT_TYPE;
            if( empty( $error ) && $this->checkExists( $object_id, $object_type ) == true )$error = self::ERROR_EXISTS_DATA;

            if( empty( $error ) )
            {
                $newFavorites = new Favorites;
                $newFavorites->item_id = $object_id;
                $newFavorites->user_id = Yii::app()->user->id;
                $newFavorites->date = time();
                $newFavorites->catalog = $object_type;
                if( !$newFavorites->save() )$error = $newFavorites->getErrors();
                                       else $data = true;
            }

            if( !empty( $error ) )$data = array( "status"=>"error", "error_message"=>$error );

            return $data;
        }
    }

    /*
     * Проверяет существование объекта в списках избранного
     */
    public function checkExists( $object_id, $object_type )
    {
        $exists = null;
        $error = $this->checkAccess();
        if( empty( $error ) )$exists = $this->checkObjectId( $object_id, $object_type ) > 0 ? true : false;

        return $exists;
    }

    /*
     * Удаляем одно избранное из списка пользователя
     */
    public function delete( $object_id, $object_type )
    {
        $error = $this->checkAccess();

        if( empty( $error ) )
        {
            $existFavorites = Favorites::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "user_id=:user_id AND `catalog`=:object_type AND item_id=:object_id" )->setParams( array( ":user_id"=>Yii::app()->user->getID(), ":object_type"=>$object_type, ":object_id"=>$object_id ) )->setCache(0) );
            if( $existFavorites && $existFavorites[0]->id )
            {
                $existFavorites[0]->delete();
                $error = $existFavorites[0]->getErrors();
                $data = true;
            }
               else $data = array( "status"=>"error", "error_message"=>self::ERROR_NO_EXISTS_DATA );

        }

        if( !empty( $error ) )$data = array( "status"=>"error", "error_message"=>$error );

        return $data;
    }

    /*
     * Выводим все избранное у текущего пользователя
     */
    public function getList( $inConditional = "", $inParams=array(), $sort = array() )
    {
        if( !Yii::app()->user->isGuest )
        {
            $Conditional = "user_id=:user_id";
            if( !empty( $inConditional ) )$Conditional .= " AND ".$inConditional;

            $params = array( ":user_id"=>Yii::app()->user->getID() );
            if( !empty( $inParams ) && is_array( $inParams ) )$params = array_merge( $params, $inParams );

            $listFavorites = Favorites::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $Conditional )->setParams( $params ) );
            return $listFavorites;
        }

        return null;
    }


    /*
     * Выводим все избранное у текущего пользователя
     */
    public function getListID( $inConditional = "", $inParams=array(), $sort = array() )
    {
        if( !Yii::app()->user->isGuest )
        {
            $Conditional = "user_id=:user_id";
            if( !empty( $inConditional ) )$Conditional .= " AND ".$inConditional;

            $params = array( ":user_id"=>Yii::app()->user->getID() );
            if( !empty( $inParams ) && is_array( $inParams ) )$params = array_merge( $params, $inParams );

            $listFavorites = Favorites::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $Conditional )->setParams( $params )->setCache(0) );
            $listId = array();
            foreach( $listFavorites as $item )
                $listId[] = $item->item_id;
            return $listId;
        }

        return null;
    }

    /*
     * Проверяем доступ, пока просто по авторизации. Затем возможно еще по каким-то критериям
     */
    private function checkAccess()
    {
        if( Yii::app()->user->isGuest )return ERROR_ACCESS;
    }

    /*
     * Проверка ID объекта
     */
    private function checkObjectId( $object_id, $object_type )
    {
        $objectId = 0;
        if( !empty( $object_id ) && $object_id>0 )
        {
            //проверяем существование
            $existFavorites = Favorites::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("user_id=:user_id AND `catalog`=:object_type AND item_id=:object_id")->setParams( array( ":user_id"=>Yii::app()->user->getID(), ":object_type"=>$object_type, ":object_id"=>$object_id ) )->setCache(0) );

            if( is_array( $existFavorites ) && sizeof( $existFavorites )>0 )$objectId = $existFavorites[0]->id;
                                                                       else $objectId = 0;

        }

        return $objectId;
    }
}
?>
