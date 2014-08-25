<?php

class CheckDescriptionTagController extends ConsoleController
{
    public $id;

    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $limit  = 30;
        $p = (int)Yii::app()->request->getParam( "p", 1 );
        $catalog = Yii::app()->request->getParam( "catalog", "" );

        Yii::app()->page->title = "Выставить слаг";
        if( !empty( $catalog ) )
        {
            $catalogS = SiteHelper::getCamelCase( $catalog );
            $items = $catalogS::fetchAll( DBQueryParamsClass::CreateParams()->setLimit($limit)->setCache(0)->setPage( $p ) );
            //echo sizeof( $items )."*";
            //die;
            foreach( $items as $item )
            {
                //echo "#".$item->id."<br/>";
                $item->description = str_replace( "< ", "<", $item->description );
                if( !$item->save() )
                {
                    print_r( $item->getErrors() );
                    //die;
                }
            }



            if( sizeof( $items ) == $limit )
            {
                $this->redirect( SiteHelper::createUrl("/console/CheckDescriptionTag", array( "catalog"=>$catalog, "p"=>$p+1 ) ) );
            }
        }
            else $items = array();

        $this->render( "index", array( "items"=>$items ) );
	}
};