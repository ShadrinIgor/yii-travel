<?php

class TravelAgencyController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogFirms";
        $this->classCategory = "";
        $this->description = "туристические агентства";
        $this->keyWord = "Туристические агентства, туристическая фирма тур, Туристические агентства узбекистана, туристические компании, туристические агентства, , , , , , , , , , ";
    }

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

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $model = $class::fetchBySlug( $key );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
            break;
        }
        if( empty($id) )$id = (int)Yii::app()->request->getParam("id", 0);

        $error = Yii::app()->request->getParam("error", "");
        $tab = Yii::app()->request->getParam("tab", "");
        $tabArray = array("description","pcomments");
        if( !in_array( $tab, $tabArray ) )$tab = "";

        if( $id > 0 )
        {
            $item = CatalogFirmsInfo::fetch( $id );
            if( empty($tab) )$activeTab = "description";
                        else $activeTab = $tab;

            if( $item->id >0 )
            {
                CCmodelHelper::colCounter( $item );
                $commentModel = new CatalogFirmsCommentsAdd();
                if( !empty( $_POST["send_comment"] ) )
                {
                    $activeTab = "pcomments";
                    $commentModel->setAttributesFromArray( $_POST["CatalogFirmsCommentsAdd"] );
                    $commentModel->firm_id = $id;
                    if( Yii::app()->user && Yii::app()->user->getId()>0 )$commentModel->user_id = Yii::app()->user->getId();
                    $commentModel->date = time();
                    if( $commentModel->save() )
                    {
                        $item->onFirmNewComment( new CEvent( $commentModel ), array( "subject"=>$commentModel->name, "firm_name"=>$item->name, "date"=>date("d.m.Y H:i"), "user_name"=>$commentModel->fio, "description"=>$commentModel->message, "link"=>SiteHelper::createUrl( "/user/firms/description", array("id"=>$item->id, "tab"=>"pcomment") ) ) );
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