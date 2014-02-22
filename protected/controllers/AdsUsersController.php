<?php

class AdsUsersController extends Controller
{
    public function actionIndex()
    {
        Yii::app()->page->title = "Объявления о работе в туристической сфере";
        $this->render( "index" );
    }

}