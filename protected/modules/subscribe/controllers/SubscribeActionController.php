<?php

//namespace subscribe;

class SubscribeActionController extends Controller
{
    var $catalog = '';
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $list = SubscribeItems::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "id DESC" )->setCache(0) );
        $listCroup = SubscribeGroups::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" ) );
        $activeCategory = Yii::app()->request->getParam( "group_id", 0 );

        $this->render("modules.subscribe.views.subscribeAction.index",  array( "list"=>$list, "listCroup"=>$listCroup, "activeCategory"=>$activeCategory ) );
	}

    public function actionEdit()
    {
        $group_id = Yii::app()->request->getParam( "group_id", 0 );
        $save = Yii::app()->request->getParam( "save", "" );
        $id = (int) Yii::app()->request->getParam("id", 0 );

        $message = "";
        if( $save == "ok" )$message = "Данные успешно сохраненны";

        if( $id )$item = SubscribeItems::fetch( $id );
                  else $item = new SubscribeItems();

        $this->render('modules.subscribe.views.subscribeAction.edit',array(
            'form'        => $item,
            'catalog'     => SiteHelper::getCamelCase( $item->tableName() ),
            'message'     => $message,
            'arrayParams' => array( "group_id" =>$group_id )
        ));
    }

    public function actionUpdate()
    {
        $id = (int) Yii::app()->request->getParam("id", 0 );
        if( !empty($id) )$model = SubscribeItems::fetch( $id );
                    else $model = new SubscribeItems();

        $message = "";
        // Сохрание полей
        if(isset($_POST[ "SubscribeItems" ]))
        {
            $model->setAttributesFromArray( $_POST[ "SubscribeItems" ] );
            if($model->save())
            {
                $this->redirect( SiteHelper::createUrl("/console/subscribe/edit", array( "id"=>$model->id, "save"=>"ok" ) ) );
            }
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $catalog = $this->catalog;
        $id = (int) Yii::app()->request->getParam("id", 0 );
        $category_id = (int) Yii::app()->request->getParam("category_id", "" );

        $array = array("catalog"=>$this->catalog);
        if( $category_id>0 )$array["category_id"] = $category_id;
        if( !empty( $this->catalog ) )
        {
            $item = $catalog::fetch($id);
            if( $item->id >0 )
            {
                $item->delete();
                $this->redirect( SiteHelper::createUrl("/console/catalog", $array ) );
            }
        }

        $this->redirect( SiteHelper::createUrl("/console/catalog", $array ) );
    }
}