<?php

class SetSlugController extends ConsoleController
{
    public $id;

    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $limit  = 50;
        $p = (int)Yii::app()->request->getParam( "p", 1 );
        $catalog = Yii::app()->request->getParam( "catalog", "" );

        Yii::app()->page->title = "Выставить слаг";
        if( !empty( $catalog ) )
        {
            $catalogS = SiteHelper::getCamelCase( $catalog );
            $items = $catalogS::fetchAll( DBQueryParamsClass::CreateParams()->setLimit($limit)->setCache(0)->setPage( $p ) );
            sizeof( $items );
            for( $i=0;$i<sizeof( $items );$i++ )
            {
                $items[$i]->slug = SiteHelper::getSlug( $items[$i] );
            }

            if( sizeof( $items ) >0 )
            {
                $this->redirect( SiteHelper::createUrl("/console/SetSlug", array( "catalog"=>$catalog, "p"=>$p+1 ) ) );
            }
        }
            else $items = array();

        $this->render( "index", array( "items"=>$items ) );
	}
};