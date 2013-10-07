<?php

class CatalogController extends ConsoleController
{
    public $catalog;
    public $id;
    public $params;
    public $DBparams;

    public function init()
    {
        $this->catalog = Yii::app()->request->getParam( "catalog", "");
        $this->id = (int)Yii::app()->request->getParam( "id", 0);

        $requestUrl = Yii::app()->request->requestUri;
        $requestUrlArr = explode( "?", $requestUrl );
        $requestUrl = $requestUrlArr[1];
        $requestUrlArr = explode( "&", $requestUrl );
        $this->params = "?".$requestUrlArr[0];
        $requestUrlArr[0] = null;

        $params = "";
        foreach( $requestUrlArr as $item )
        {
            if( !empty( $item ) )
            {
                $itemArr = explode( "=", $item );
                if( !empty( $params ) )$params.=" AND ";
                $params .= "`".trim( $itemArr[0] )."`='".trim( $itemArr[1] )."'";
                $this->params .= "&".$item;
            }
        }

        $this->DBparams = $params;

//        DBQueryParamsClass::CreateParams()->setConditions("status_id=:status_id")->setParams( array(":status_id"=>2) )
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

            if( $item->id >0 )$listImage = CatGallery::findByAttributes( array( "catalog"=>$item->tableName(), "item_id"=>$item->id ) );
                         else $listImage=array();

            $this->render('edit',array(
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
                if($model->saveWithRelation())
                {
                    $message = "Данные успешно сохраненны";

                    //$this->redirect(array('view','id'=>$model->id));
                }
            }

            // Сохранение TITLE галлереи
            if( !empty( $_POST["image_submit"] )  && !empty( $_POST["image"] ) )
            {
                foreach( $_POST["image"] as $key=>$value )
                {
                    $imageModel = CatGallery::fetch( $key );
                    if( $imageModel->id >0 )
                    {
                        $imageModel->name = $value;
                        $imageModel->save();
                    }
                    $message = "Галлерея успешно сохраненна";
                }
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

        if( !empty( $this->catalog ) )
        {
            $item = $catalog::fetch($id);
            if( $item->id >0 )
            {
                $item->delete();
                $this->redirect( SiteHelper::createUrl("/console/catalog", array("catalog"=>$this->catalog)) );
            }
        }

        $this->redirect( SiteHelper::createUrl("/console/catalog", array("catalog"=>$this->catalog)) );
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $catalog = $this->catalog;

        if( !empty( $this->catalog ) )
        {
            $list = $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(100)->setConditions( $this->DBparams )->setCache(0) );
            $this->render("index", array( "list"=>$list, "controller"=>$this ));
        }
	}
}
