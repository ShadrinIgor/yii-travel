<?php

//namespace subscribe;

class SubscribeActionController extends Controller
{
    var $catalog = '';
    var $viewPath = 'modules.subscribe.views.subscribeAction.';
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $list = SubscribeItems::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "id DESC" )->setCache(0) );
        $listCroup = SubscribeGroups::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" ) );
        $activeCategory = Yii::app()->request->getParam( "group_id", 0 );

        $this->render($this->viewPath."index",  array( "list"=>$list, "listCroup"=>$listCroup, "activeCategory"=>$activeCategory ) );
	}

    public function actionEdit( $message = "" )
    {
        $group_id = Yii::app()->request->getParam( "group_id", 0 );
        $save = Yii::app()->request->getParam( "save", "" );
        $id = (int) Yii::app()->request->getParam("id", 0 );

        if( $save == "ok" )$message = "Данные успешно сохраненны";

        if( $id )$item = SubscribeItems::fetch( $id );
                  else $item = new SubscribeItems();

        $this->render($this->viewPath.'edit',array(
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
                else $this->actionEdit( print_r( $model->getErrors(), true ) );
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
                $this->redirect( SiteHelper::createUrl("/console/subscribe", $array ) );
            }
        }

        $this->redirect( SiteHelper::createUrl("/console/subscribe", $array ) );
    }

    public function actionUsers()
    {
        $list = SubscribeUsers::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "id DESC" )->setCache(0) );
        $listCroup = SubscribeGroups::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" ) );
        $activeCategory = Yii::app()->request->getParam( "group_id", 0 );

        $this->render($this->viewPath."users",  array( "list"=>$list, "listCroup"=>$listCroup, "activeCategory"=>$activeCategory ) );
    }

    public function actionUserEdit( $message = "" )
    {
        $group_id = Yii::app()->request->getParam( "group_id", 0 );
        $save = Yii::app()->request->getParam( "save", "" );
        $id = (int) Yii::app()->request->getParam("id", 0 );

        if( $save == "ok" )$message = "Данные успешно сохраненны";

        if( $id )$item = SubscribeUsers::fetch( $id );
        else $item = new SubscribeUsers();

        $this->render($this->viewPath.'userEdit',array(
                'form'        => $item,
                'catalog'     => SiteHelper::getCamelCase( $item->tableName() ),
                'message'     => $message,
                'arrayParams' => array( "group_id" =>$group_id )
            ));
    }

    public function actionUserUpdate()
    {
        $id = (int) Yii::app()->request->getParam("id", 0 );
        if( !empty($id) )$model = SubscribeUsers::fetch( $id );
        else $model = new SubscribeUsers();

        $message = "";
        // Сохрание полей
        if(isset($_POST[ "SubscribeUsers" ]))
        {
            $model->setAttributesFromArray( $_POST[ "SubscribeUsers" ] );

            // проверяем email среди уже существующих
            $checkEmail = CatalogUsers::findByAttributes( array( "email"=>$model->email ) );

            if( sizeof($checkEmail) == 0 )
            {
                if( $model->save())
                {
                    $this->redirect( SiteHelper::createUrl("/console/subscribe/userEdit", array( "id"=>$model->id, "save"=>"ok" ) ) );
                }
                    else $this->actionUserEdit( print_r( $model->getErrors(), true ) );
            }
                else $this->actionUserEdit( print_r( "Такой Email уже зарегестрирован в системе", true ) );
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionUserDelete()
    {
        $id = (int) Yii::app()->request->getParam("id", 0 );
        if( !empty($id) )
        {
            $model = SubscribeUsers::fetch( $id );
            if( $model->id > 0 )$model->delete();
        }

        $this->redirect( SiteHelper::createUrl("/console/subscribe/users" ) );
    }
}