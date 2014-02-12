<?php

class AddController extends Controller
{
    public function actionIndex()
    {
        $arrayTab = array( "travel-agency", "curorts", "hotels", "vacancy-resume", "ads-items", "other-info" );
        $arrayTabTitle = array( "travel-agency"=>"добавление туристической фирмы", "curorts"=>"добавление курорта/зоны отдыха", "hotels"=>"добавление отеля/гостиницы","vacancy-resume"=>"добавление вакансии или резюме", "ads-items"=>"добавление частных объявлений", "other-info"=>"добавление прочей информации" );

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

        Yii::app()->page->title = $arrayTabTitle[ $activeTab ].", бесплатное добавление туристической информации на сайт";
        $this->render("index", array( "activeTab"=>$activeTab, "activeTitle"=>$arrayTabTitle[ $activeTab ] ));
    }

    public function actionConfirm()
    {
        $this->render("confirm");
    }
}