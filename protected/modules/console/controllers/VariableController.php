<?php

class VariableController extends ConsoleController
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
        Yii::app()->page->title = "Переменные среды";

        $listVeribals = I18n::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setCache(0) );
        $this->render( "index", array( "list"=>$listVeribals ) );
	}

    public function actionEdit()
    {
        $message = "";
        if( !empty( $this->id ) )$item = I18n::fetch( $this->id );
                            else $item = new I18n();

        $itemTransplate = I18nTranslate::fetch( $this->id );

        $this->render('edit',array(
            'form'        => $item,
            'translate'   => $itemTransplate,
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
        if( !empty( $_POST[ "I18n" ] ) )
        {
            if( $this->id>0 )
            {
                $model = I18n::fetch( $this->id );
                $modelTranslate = I18nTranslate::fetch( $this->id );
            }
                else
            {
                $model = new I18n();
                $modelTranslate = new I18nTranslate();
            }

            $message = "";
            // Сохрание полей
            $model->setAttributesFromArray( $_POST[ "I18n" ] );
            if($model->save())
            {
                $modelTranslate->id = $model->id;
                $modelTranslate->translation = $model->message;
                $modelTranslate->language = Yii::app()->language;

                if( !$modelTranslate->save() )
                    print_r( $modelTranslate->getErrors() );

                $message = "Данные успешно сохраненны";
            }

            $this->render('edit',array(
                'form'            => $model,
                'translate'       => $modelTranslate
            ));
        }
            else $this->redirect( SiteHelper::createUrl("/console/variable") );
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
            $item = I18n::fetch($this->id);
            if( $item->id >0 )
            {
                $item->delete();

                $itemTranslate = I18nTranslate::fetch($this->id);
                $itemTranslate->delete();
                $this->redirect( SiteHelper::createUrl("/console/variable") );
            }
        }

        $this->redirect( SiteHelper::createUrl("/console/variable") );
    }

};