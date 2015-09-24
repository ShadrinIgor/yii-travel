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

    static public function getRelationLeftItems( CCModel $model, $classRelation )
    {
        $leftClass = get_class( $model );
        $res = CatRelations::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "leftClass=:leftClass AND rightClass=:rightClass AND leftId=:id" )->setParams( array( ":leftClass"=>$leftClass, ":rightClass"=>$classRelation, ":id"=>$model->id ))->setLimit(-1)->setCache(0) );
        $list = [];
        foreach( $res as $items )
        {
            $list[] = $items->rightId;
        }
        return $list;
    }
}