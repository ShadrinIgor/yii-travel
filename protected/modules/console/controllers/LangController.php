<?php

class LangController extends ConsoleController
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
        Yii::app()->page->title = "Языки";

        $list = I18n::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setCache(0) );
        $this->render( "index", array( "list"=>$list ) );
	}

    public function actionEdit()
    {
        $message = "";
        $lang = CatLang::fetchAll();

        if( !empty( $_POST["trans"] ) )
        {
            for( $n=0;$n<sizeof( $lang );$n++ )
            {
                $trans = $_POST["trans"][ $n ];
                if( $trans["id"] >0 || $trans["name"] )
                {
                    if( $trans["id"] >0 )
                    {
                        $model = I18nTranslate::fetch( $trans->id );
                    }
                        else $model = new I18nTranslate();

                    $model->setAttributesFromArray( $trans );
                    $model->i18n_id = $this->id;
                    if( !$model->save() )
                        print_r( $model->getErrors() );
                }
            }
        }

        $list = array();
        if( !empty( $this->id ) )
        {
            $item = I18n::fetch( $this->id );
            $list = I18nTranslate::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "i18n_id=:id" )->setParams( array( ":id"=>$item->id ) )->setLimit(-1)->setCache(0) );
        }
            else $item = new I18n();


        $this->render('edit',array(
            'form'        => $item,
            'list'        => $list,
            'lang'        => $lang,
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