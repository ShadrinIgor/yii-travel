<?php
/**
 * User: Igor
 * Date: 06.12.13
 * Данный класс будет содержать вспомогательные функции для работы со связями
 */

class RelationHelper {

    static public function getRelationItems( $relation )
    {
        $relationTable = $relation[1];
        if( !empty($relationTable) )return $relationTable::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("name")->setLimit(-1)->setCache(0) );
                               else false;
    }
}