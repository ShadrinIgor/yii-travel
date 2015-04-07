<?php

class TravelAgencyController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogFirms";
        $this->classCategory = "";
        $this->description = Yii::t("tours", "туристические агентства Узбекистана, вы можете посмотреть туристические предложения, акции скидки");
        $this->keyWord = Yii::t("tours", "туристические фирмы, туристическая фирма тур, Туристические агентства Узбекистана, туристические компании, ооо туристическая фирма, сайты туристических фирм, туристические фирмы Узбекистана, туристические фирмы Ташкент");
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        if( !empty( $_GET[ "slug" ] ) )
        {
            $model = $class::fetchBySlug( trim( $_GET[ "slug" ] ) );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
        }
        if( empty($id) )$id = (int)Yii::app()->request->getParam("id", 0);

        $error = Yii::app()->request->getParam("error", "");
        $tab = Yii::app()->request->getParam("tab", "");
        $tabArray = array("description","pcomments", "tours");
        if( !in_array( $tab, $tabArray ) )$tab = "";

        // Ошибка при не правельно ID
        $error = Yii::t("page", "Произошла ошибка перехода на страницу, проверьте правильно написания адреса страницы");

        if( empty($id) && !empty( $_GET[ "slug" ] ) )
        {
            $ar = explode( "-",  $_GET[ "slug" ] );
            $id = $ar[0];
        }

        if( $id > 0 )
        {
            $item = CatalogFirmsInfo::fetch( $id );
            if( empty($tab) )$activeTab = "description";
                        else $activeTab = $tab;

            if( $item->id >0 )
            {
                LogHelper::save("firms", $item->id, "show");
                CCModelHelper::colCounter( $item );
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
                        $item->onFirmNewComment( new CEvent( $commentModel ), array( "subject"=>$commentModel->name, "firm_name"=>$item->name, "date"=>date("d.m.Y H:i"), "user_name"=>$commentModel->fio, "description"=>$commentModel->message, "link"=>SiteHelper::createUrl( "/user/firms/description", array("id"=>$item->id, "tab"=>"pcomments") ) ) );
                        $commentModel = new CatalogFirmsCommentsAdd();
                        $commentModel->formMessage = Yii::t("tours", "Сообщение отправлено, после модерации оно будет Опубликовано.");
                    }
                }

                Yii::app()->page->title = $item->name." - ".Yii::t("page", "туристическое агенство")." ".$item->country_id->name_2 ." ".$item->city_id->name;

                // Поля про поиско по турам
                $tourClass = new CatalogToursFirms();
                $arrSearchFieldsTours = $tourClass->getSearchAttributes();

                $this->render('description',
                    array(
                        "item" => $item,
                        "activeTab"=>$activeTab,
                        "commentModel"=>$commentModel,
                        "otherFirms" => CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND id!=:id")->setParams(array(":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "listGallery" => CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:items_id")->setParams(array(":catalog"=>"catalog_firms", ":items_id"=>$item->id))->setLimit(15) ),
                        "arrSearchFieldsTours" => $arrSearchFieldsTours
                    ));

            }
            else throw new CHttpException("",$error);
        }
        else throw new CHttpException("",$error);
    }
}