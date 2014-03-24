<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			//  captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

        Yii::app()->page->title = "Первая страница";
        $content = CatalogContent::fetchBySlug( "about_us" );

        //$finishDate = time() - 60*60*24*30;
        //$items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("status_id=1 AND is_hot=:hot AND `date`>=:date")->setParams(array(":hot"=>1, ":date"=>$finishDate ) )->setLimit(20)->setCache(0) );

        header("cache-control: private, max-age = 86400");
        $this->render('index', array( "controller"=>$this, "content"=>$content, "items"=>array() ));
	}

    public function actionPage( $slug = "" )
    {
        if( empty( $slug ) )$page = Yii::app()->request->getParam("page", "");
                       else $page = $slug;

        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $page = $key;
            break;
        }

        if( !empty( $page ) )
        {
            $pageInfo = CatalogContent::fetchBySlug( $page );

            if( $pageInfo->id >0 )
            {
                Yii::app()->page->title = $pageInfo->name;
                $this->render('page', array( "content"=>$pageInfo ));
            }
        }

    }

    /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    public function actionGetInfo()
    {
        echo SiteHelper::getAccessInfo();
    }

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{


		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}

        $pageInfo = CatalogContent::fetchBySlug( "contact" );
		$this->render('contact',array('model'=>$model, "content"=>$pageInfo));
	}

/*
	/**
	 * Displays the login page
	 *
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	**
	 * Logs out the current user and redirect to homepage.
	 *
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);

*/
}