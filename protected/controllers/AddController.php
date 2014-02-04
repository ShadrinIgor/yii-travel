<?php

class AddController extends Controller
{
    public function actionIndex()
    {
        $activeTab = Yii::app()->request->getParam("tab","tfirm");
        $arrayTab = array( "tfirm", "tcurorts", "thotels", "tvakansi", "titems");
        if( !in_array( $activeTab, $arrayTab) )$activeTab = "tfirm";

        $this->render("index", array( "activeTab"=>$activeTab ));
    }

    public function actionConfirm()
    {
        $this->render("confirm");
    }
}