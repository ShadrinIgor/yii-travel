<?php

class JobsController extends Controller
{
    public function actionIndex()
    {
        Yii::app()->page->title = Yii::t("page", "Объявления о работе в туристической сфере");
        $this->render( "index" );
    }

}