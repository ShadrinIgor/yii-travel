<?php

class StatController extends ConsoleController
{
    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex( $limit = 50 )
	{
        Yii::app()->page->title = "Статистика";

        $list = CatLog::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "id DESC" )->setLimit(50)->setCache(0) );
        $this->render( "index", array( "list"=>$list ) );
	}

};