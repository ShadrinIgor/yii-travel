<?php

class BannersController extends ConsoleController
{
    public $id;

    public function init()
    {
        $this->id = (int)Yii::app()->request->getParam( "id", 0);
    }


    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->page->title = "Банеры";

        $banners = ExBanner::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setCache(0) );
        $bannersCategory = ExBannerCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setCache(0) );
        $this->render( "index", array( "banners"=>$banners, "bannersCategory"=>$bannersCategory ) );
	}

    public function actionEdit()
    {
        $message = "";
        if( !empty( $this->id ) )$item = ExBanner::fetch( $this->id );
                            else $item = new ExBanner();

        $this->render('edit',array(
            'form'        => $item,
            'message'     => $message,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {
        if( !empty( $_POST["ExBanner"] ) )
        {
            if( $this->id>0 )
            {
                $model = ExBanner::fetch( $this->id );
            }
                else
            {
                $model = new ExBanner();
            }

            $message = "";
            // Сохрание полей
            $model->setAttributesFromArray( $_POST["ExBanner"] );
            if($model->save())
            {
                $message = "Данные успешно сохраненны";
            }
                else print_r( $model->getErrors() );

            $this->render('edit',array(
                'form'            => $model,
                'message'         => $message,
            ));
        }
            //else $this->redirect( SiteHelper::createUrl("/console/banners") );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        if( $this->id >0  )
        {
            $item = ExBanner::fetch($this->id);
            if( $item->id >0 )
            {
                $item->delete();

                $this->redirect( SiteHelper::createUrl("/console/banners") );
            }
        }

        $this->redirect( SiteHelper::createUrl("/console/banners") );
    }

};