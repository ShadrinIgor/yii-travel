<?php

class AddController extends Controller
{
    public function actionIndex()
    {
        $activeTab = "tfirm";
        $this->render("index", array( "activeTab"=>$activeTab ));
    }
}