<?php

class CheckDescriptionController extends ConsoleController
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
            for( $i=0;$i<sizeof( $items );$i++ )
            {
                if( strpos( $items[$i]->description, "</xml>" ) !== false )
                {
                    $arr = explode( "</xml>", $items[$i]->description );
                    $items[$i]->description = $arr[1];
                    if( empty( $items[$i]->description ) )$items[$i]->description = "  - ";
                    if( !$items[$i]->save() )
                    {
                        //print_r( $items[$i]->getErrors() );
                        //die;
                    }
                }
            }


            if( sizeof( $items ) == $limit )
            {
                $this->redirect( SiteHelper::createUrl("/console/CheckDescription", array( "catalog"=>$catalog, "p"=>$p+1 ) ) );
            }
        }
            else $items = array();

        $this->render( "index", array( "items"=>$items ) );
	}
};