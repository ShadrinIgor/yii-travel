<?php

class Site2Controller extends Controller
{

    public function actionIndex()
	{
        $this->layout = '//layouts/main2';
        Yii::app()->page->title = Yii::t("page", "Туристический портал Узбекистана, отдых, туры, туроператоры, путешестви");
        header("cache-control: private, max-age = 86400");
        $this->render('index', array( "controller"=>$this, "content"=>"", "items"=>array() ));
	}

}