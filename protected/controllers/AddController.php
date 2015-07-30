<?php

class AddController extends Controller
{
    public function init()
    {
        parent::init();
        $this->layout = '//layouts/main2';
    }

    public function actionIndex()
    {
        $arrayTab = array( "travel-agency", "curorts", "hotels", "vacancy-resume", "ads-items", "other-info" );
        $arrayTabTitle = array( "travel-agency"=>Yii::t("page", "добавление туристической фирмы" ), "curorts"=>Yii::t("page", "добавление курорта/зоны отдыха"), "hotels"=>Yii::t("page", "добавление отеля/гостиницы"),"vacancy-resume"=>Yii::t("page", "добавление вакансии или резюме"), "ads-items"=>Yii::t("page", "добавление частных объявлений"), "other-info"=>Yii::t("page", "добавление прочей информации") );

        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) && $_GET[$key]!='null' )continue;
            if( in_array( $key, $arrayTab) )
            {
                $activeTab = $key;
            }
            break;
        }
        if( empty( $activeTab ) )$activeTab = $arrayTab[0];

        Yii::app()->page->title = $arrayTabTitle[ $activeTab ].", ".Yii::t("page", "бесплатное добавление туристической информации на сайт" );
        $this->render("index", array( "activeTab"=>$activeTab, "activeTitle"=>$arrayTabTitle[ $activeTab ] ));
    }

    public function actionConfirm()
    {
        $this->render("confirm");
    }
}