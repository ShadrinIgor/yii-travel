<?php

class PageController extends Controller
{
	public function actionIndex( $slugInput = "" )
	{
        $error = false;

        $slug = !empty( $_GET["slug"] ) ? $slug = SiteHelper::checkedVaribal( $_GET["slug"] ) : "";
        if( empty($slug) && !empty( $slugInput ) )$slug = $slugInput;

        if( !empty( $slug ) )
        {
            $page = CatalogContent::fetchBySlug( $slug );
        }

        if( !empty( $page ) && $page->id >0 )
        {
            $this->render('index',
                    array
                    (
                        "page"=>$page
                    )
                );
        }
         else $this->redirect("/site/error");
	}

    public function actionAbout()
    {
        $this->actionIndex( "about_us" );
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