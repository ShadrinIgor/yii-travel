<?php

class FirmsController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            //  captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    var $slug;
	public function actionIndex()
	{
        $this->slug = Yii::app()->request->getParam("slug", "");
        if( empty( $this->slug ) )$this->index();
                       else $this->actionDescription();
	}

    public function index()
    {
        $this->render( 'index' );
    }

    public function actionDescription()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        $error = Yii::app()->request->getParam("error", "");

        if( $id > 0 )
        {
            $item = CatalogFirmsInfo::fetch( $id );
            $activeTab = "description";

            if( $item->id >0 )
            {
                $commentModel = new CatalogFirmsCommentsAdd();
                if( !empty( $_POST["send_comment"] ) )
                {
                    $activeTab = "pcomments";
                    $commentModel->setAttributesFromArray( $_POST["CatalogFirmsCommentsAdd"] );
                    $commentModel->firm_id = $id;
                    $commentModel->user_id = Yii::app()->user->getId();
                    $commentModel->date = time();
                    if( $commentModel->save() )
                    {
                        $commentModel = new CatalogFirmsCommentsAdd();
                        $commentModel->formMessage = "Сообщение отправленно, после модерации оно будет опубликованно.";
                    }
                }

                Yii::app()->page->title = $item->name;

                $this->render('description',
                    array(
                        "item" => $item,
                        "activeTab"=>$activeTab,
                        "commentModel"=>$commentModel,
                        "otherFirms" => CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND id!=:id")->setParams(array(":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firmsTours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND firm_id=:firm_id")->setParams(array(":firm_id"=>$item->id))->setOrderBy("col DESC")->setLimit(-1) ),
                        "listGallery" => CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:items_id")->setParams(array(":catalog"=>"catalog_firms", ":items_id"=>$item->id))->setLimit(15) ),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:firm_id" )->setParams( array( ":firm_id"=>$item->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
        else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
    }
}