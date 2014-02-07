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
        Yii::app()->page->title = "Выставить слаг";
        if( !empty( $_POST["submit_slug"] ) && !empty( $_POST["satalog"] ) )
        {
            $catalog = SiteHelper::getCamelCase( $_POST["satalog"] );
            $items = $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1)->setCache(0) );
            for( $i=0;$i<sizeof( $items );$i++ )
            {
                $items[$i]->slug = SiteHelper::getSlug( $items[$i] );
                $items[$i]->save();

            }
        }
            else $items = array();

        $this->render( "index", array( "items"=>$items ) );
	}
};