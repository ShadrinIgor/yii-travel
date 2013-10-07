<?php

class NewsController extends Controller
{
	public function actionIndex()
	{

        $newsId = (int)Yii::app()->getRequest()->getParam("id",0);

        if( empty( $newsId ) )
        {
                $this->render('index',
                    array(
                       "content" => CatalogContent::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category_id")->setParams( array( ":category_id" =>2 ) ) )
                    ));
        }
            else
        {
            $newsData = CatalogContent::fetch( $newsId );
            if( $newsData->id>0 )
            {
                $this->render('description',
                    array(
                        "content"           => $newsData
                    ));
            }

        }
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}