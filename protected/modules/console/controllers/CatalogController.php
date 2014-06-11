<?php

class CatalogController extends ConsoleController
{
    public $catalog;
    public $id;
    public $params;
    public $DBparams;
    public $arrayParams;

    public function init()
    {
        $this->catalog = Yii::app()->request->getParam( "catalog", "");
        $this->id = (int)Yii::app()->request->getParam( "id", 0);

        $requestUrl = Yii::app()->request->requestUri;
        $requestUrlArr = explode( "?", $requestUrl );
        $this->params = "?".$requestUrlArr[1];
        $requestUrlArr = explode( "&", $requestUrlArr[1] );

        $params = "";
        $this->arrayParams = array();
        $array = array( "p", "catalog" );
        foreach( $requestUrlArr as $item )
        {
            if( !empty( $item ) )
            {
                $itemArr = explode( "=", $item );
                if( !in_array( $itemArr[0], $array ) )
                {
                    $this->arrayParams[ $itemArr[0] ] = $itemArr[1];
                    if( !empty( $params ) )$params.=" AND ";
                    $params .= "`".trim( $itemArr[0] )."`='".trim( $itemArr[1] )."'";
                }
            }
        }

        $this->arrayParams["catalog"] = $this->catalog;
        $this->DBparams = $params;
    }

    public function filters()
    {
/*        Yii::import( "console.filters.AccessFilter" );

        return array(
            'CheckAccess'
//            array('console.filters.AccessFilter'),
//            array('console.filters.CatalogFilter'),
        );*/
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEdit()
    {
        if( !empty( $this->catalog ) )
        {
            $message = "";
            $catalog = $this->catalog;
            $action = Yii::app()->request->getParam( "action", "" );

            if( $this->id )$item = $catalog::fetch( $this->id );
                      else $item = new $catalog();

            // Удаление картинки
            if( $action == "img_del" )
            {
                $imageField = Yii::app()->request->getParam( "field", "" );
                if( !empty( $imageField ) )
                {
                    ImageHelper::deleteFile( $item, $imageField );
                    $item->save();
                    $message = "Фото успешно удаленно";
                }
            }

            // Удаляем картинки в галлере
            if( $action == "gal_del" )
            {
                $id = (int) Yii::app()->request->getParam( "img_id", 0 );
                if( !empty( $id ) )
                {
                    $imageModel = CatGallery::fetch( $id );
                    if( $imageModel->id >0 )
                    {
                        $imageModel->delete();
                        $message = "Фото успешно удаленно";
                    }
                }
            }

            $addGallery = new CatGallery();

            if( $item->id >0 )$listImage = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "catalog=:catalog AND item_id=:item_id" )->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setOrderBy("pos, id") );
                         else $listImage=array();

            $this->arrayParams["catalog"] = $catalog;

            $this->render('edit',array(
                'arrayParams' => $this->arrayParams,
                'controller'  => $this,
                'form'        => $item,
                'catalog'     => SiteHelper::getCamelCase( $item->tableName() ),
                'listImage'   => $listImage,
                'message'     => $message,
                'addGallery'  => $addGallery
            ));

        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CatalogCountry;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogCountry']))
		{
			$model->attributes=$_POST['CatalogCountry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
        if( $this->catalog )
        {
            $catalog = ucwords( $this->catalog );
            $id = (int) Yii::app()->request->getParam("id", 0 );
            if( !empty($id) )$model = $catalog::fetch( $id );
                        else $model = new $catalog();

            $message = "";
            // Сохрание полей
            if(isset($_POST[ $catalog ]))
            {
                $model->setAttributesFromArray( $_POST[ $catalog ] );
                if( !empty( $_FILES[ $catalog ] ) )
                {

                    foreach(  $_FILES[ $catalog ]["name"] as $key=>$field )
                    {
                        if( property_exists( $model, $key ) )
                            $model->$key = $field;
                    }
                }

                if($model->saveWithRelation())
                {
                    $message = "Данные успешно сохраненны";

                    //$this->redirect(array('view','id'=>$model->id));
                }
            }

            // Сохранение TITLE галереи
            if( !empty( $_POST["image_submit"] )  && !empty( $_POST["image"] ) )
            {
                foreach( $_POST["image"] as $value )
                {
                    if( $value["id"]>0 )
                    {
                        $imageModel = CatGallery::fetch( $value["id"] );
                        if( $imageModel->id >0 )
                        {
                            $imageModel->name = $value["name"];
                            $imageModel->pos = $value["pos"];
                            $imageModel->save();
                        }
                    }
                }
                $message = "Галерея успешно сохраненна";
            }

            // Добвление картинки
            $addGallery = new CatGallery();
            if( !empty( $_POST["submit_add_gallery"] ) && !empty( $id ) )
            {
                $addGallery->setAttributesFromArray( $_POST["CatGallery"] );
                $addGallery->image = $_FILES["CatGallery"]["name"][ "image" ];
                $addGallery->catalog = $model->tableName();
                $addGallery->item_id = $id;
                $addGallery->save();
                $addGallery = new CatGallery();
            }

            if( $model->id >0 )$listImage = CatGallery::findByAttributes( array( "catalog"=>$model->tableName(), "item_id"=>$model->id ) );
                else $listImage=array();

            $this->render('edit',array(
                'arrayParams' => $this->arrayParams,
                'form'        => $model,
                'catalog'     => $this->catalog,
                'listImage'   => $listImage,
                'message'     => $message,
                'addGallery'  => $addGallery
            ));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $catalog = $this->catalog;

        if( !empty( $this->catalog ) )
        {
            $page = (int) Yii::app()->request->getParam("p", 1 );
            $find = Yii::app()->request->getParam( "find", "");

            if( empty( $find ) )
            {
                $list = $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(50)->setConditions( $this->DBparams )->setOrderBy("id DESC")->setCache(0)->setPage($page) );
                $allCount = $catalog::count( DBQueryParamsClass::CreateParams()->setLimit(-1)->setConditions( $this->DBparams )->setCache(0) );
            }
                else
            {
                $list = $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(100)->setConditions( "( id='".$find."' OR ( name like '%".$find."%' OR description like '%".$find."%' ) )" )->setParams( array( ":find"=>$find ) )->setOrderBy("id DESC")->setCache(0) );
                $allCount = 0;
            }

            $listCategory = array();
            if( property_exists( $catalog, "category_id" ) )
            {
                $newModel = new $catalog();
                $relation = $newModel->getRelationByField( "category_id" );
                $categoryClass = $relation[1];
                if( !property_exists( $catalog, "owner" ) )$listCategory = $categoryClass::fetchAll();
                                                      else $listCategory = $categoryClass::findByAttributes( array("owner"=>0) );
            }

            $this->render("index", array( "arrayParams"=>$this->arrayParams, "catalogClass"=>$catalog, "listCategory"=>$listCategory,"list"=>$list, "allCount"=>$allCount, "controller"=>$this, "page"=>$page ));
        }
	}
}
