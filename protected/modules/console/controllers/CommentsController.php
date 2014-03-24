<?php

class CommentsController extends ConsoleController
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

        $comments = CatComments::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "date DESC" )->setLimit(-1)->setCache(0) );
        $this->render( "index", array( "comments"=>$comments ) );
    }

    public function actionEdit()
    {
        $message = "";
        if( !empty( $this->id ) )
        {
            $item = CatComments::fetch( $this->id );
            $item->new = 0;
            $item->save();
        }
                            else $item = new CatComments();

        $catalogClass = SiteHelper::getCamelCase( $item->catalog );
        $catalogItemModel = $catalogClass::fetch( $item->item_id );

        $this->render('edit',array(
            'form'        => $item,
            'message'     => $message,
            "catalogItemModel"=>$catalogItemModel
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {
        if( !empty( $_POST["CatComments"] ) )
        {
            if( $this->id>0 )
            {
                $model = CatComments::fetch( $this->id );
            }
            else
            {
                $model = new CatComments();
            }

            $catalogClass = SiteHelper::getCamelCase( $model->catalog );
            $catalogItemModel = $catalogClass::fetch( $model->item_id );

            $message = "";
            // Сохрание полей
            $model->setAttributesFromArray( $_POST["CatComments"] );
            if($model->save())
            {
                $message = "Данные успешно сохраненны";
            }
            else print_r( $model->getErrors() );

            $this->render('edit',array(
                'form'            => $model,
                'message'         => $message,
                "catalogItemModel"=>$catalogItemModel
            ));
        }
        //else $this->redirect( SiteHelper::createUrl("/console/comments") );
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
            $item = CatComments::fetch($this->id);
            if( $item->id >0 )
            {
                $item->delete();

                $this->redirect( SiteHelper::createUrl("/console/comments") );
            }
        }

        $this->redirect( SiteHelper::createUrl("/console/comments") );
    }

};