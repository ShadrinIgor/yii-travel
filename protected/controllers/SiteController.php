<?php

class SiteController extends Controller
{

    public function actionLog( )
    {
        $type = Yii::app()->request->getParam("type", 0);
        $id = (int)Yii::app()->request->getParam("id", 0);
        $action = Yii::app()->request->getParam("action", 0);
        LogHelper::save( $type, $id, $action );
    }
    /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

    public function actionSession()
    {
        Yii::app()->winding->checkSession();
    }

    public function actionSession1()
    {
//        print_r( $_SERVER );
        Yii::app()->winding->userVisit();
    }

    public function actionUpdateProxi()
    {
        Yii::app()->winding->updateListProxi();
    }

    public function actionTest()
    {
        // Расчет ретинга фирмы
        /*
                * описание
                    * Сайт, Контакты, Адрес, большой текст с описанем
                    * если не описания то - бал
                * галлерея
                    * + бал за каждую картинку
                    * - бал если нет не одной каринки
                * туры
                    * + бал за каждый тур ( если есть рейтинг тура то вмест бала сумируем его если нет то просто 10 )
                    * если нет не одного тура то выставляет бал 0
                * акции
                    * + бал за каждую акцию
                * Коментарии и отзывы
                    * + бал за каждый комментарий
         */
        $id = (int)Yii::app()->request->getParam("id", 0);

        if( $id >0 )
        {
            $rating = 0;
            $firmModel = CatalogFirms::fetch( $id );

            // Проверяем описание
            if( $firmModel->www )$rating += 10;
            if( $firmModel->tel && $firmModel->email )$rating += 10;
            if( $firmModel->description )
            {
                $rating += 10;
                if( strlen( $firmModel->description ) > 500 )$rating += 20;
            }
                else $rating -= 10;

            if( $firmModel->image )$rating += 10;
                              else $rating -= 10;

            // end ( Проверяем описание )

            // Галлрея
            $images = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_firms' AND item_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $images > 0 )
            {
                $rating += ( $images*5 );
            }
                else $rating -= 10;

            // Туры
            $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:id" )->setParams( array( ":id"=>$id ) )->setLimit(-1) );
            foreach( $tours as $tour )
            {
                if( $tour->rating >0 )$rating += $tour->rating;
                                 else $rating += 10;
            }

            if( sizeof( $tours ) == 0 )$rating = 0;


            // Туры
            $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:id" )->setParams( array( ":id"=>$id ) )->setLimit(-1) );
            foreach( $tours as $tour )
            {
                if( $tour->rating >0 )$rating += $tour->rating;
                                 else $rating += 10;
            }

            if( sizeof( $tours ) == 0 )$rating = 0;

            // Акции
            $sales = CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $sales > 0 )
            {
                $rating += ( $sales*5 );
            }

            // Коментарии
            $comments = CatalogFirmsComments::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $comments > 0 )
            {
                $rating += ( $comments*5 );
            }

            echo $rating;
        }
    }

    public function actionIndex()
	{
//        echo Yii::app()->getLanguage()."*";
/*        $model = CatalogTours::fetch( 7 );
        // echo $model->description."<hr/><br/>";

        $transModel = TranslateHelper::getTranslateModel( "CatalogTours", $model->id, "en" );
        if( !$transModel->id )
        {
            TranslateHelper::setTranslate( $model, $transModel );
        }

        $text = $transModel->description;

        echo $text."<br/>";
        die;*/

        //SiteHelper::mailto( "Привет Чулик", "info@world-travel.uz", "shadrin.igor@gmail.com", "Тут будет текст сообщения. Тут будет текст сообщения. " );

        Yii::app()->page->title = Yii::t("page", "Туристический портал Узбекистана, отдых, туры, туроператоры, путешестви");
        $content = CatalogContent::fetchBySlug( "about_us" );

        //$finishDate = time() - 60*60*24*30;
        //$items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("status_id=1 AND is_hot=:hot AND `date`>=:date")->setParams(array(":hot"=>1, ":date"=>$finishDate ) )->setLimit(20)->setCache(0) );

        header("cache-control: private, max-age = 86400");
        $this->render(YII_SUBDOMAIN.'index', array( "controller"=>$this, "content"=>$content, "items"=>array() ));
	}

    public function actionReloadBanner()
    {
        echo Yii::app()->banners->getBannerByCategory( "top" );
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

    public function actionAddFirm()
    {
        $this->render("addFirm");
    }

    public function actionSubscribeOpen()
    {
        $email = Yii::app()->request->getParam("email", "");
        $subscribe = (int)Yii::app()->request->getParam("subscribe", 0);

        if( !empty( $email ) && !empty( $subscribe ) )
        {
            $checkModel = SubscribeSend::findByAttributes( array( "email"=>$email, "item_id"=>$subscribe ) );
            if( sizeof( $checkModel ) >0 && $checkModel[0]->is_open == 0 )
            {
                $checkModel[0]->is_open = 1;
                $checkModel[0]->save();
            }
        }
    }

    public function actionUnSubscribe()
    {
        $email = Yii::app()->request->getParam("email", "");
        $hash = Yii::app()->request->getParam("hash", "");
        $hashCheck = substr( md5( md5( $email ) ), 3, 8 );
        $error = "";

        if( $hash == $hashCheck )
        {
            Yii::import("modules.subscribe.models.*");
            $emailModel = CatalogUsers::findByAttributes( array( "email"=>$email ) );
            if( $emailModel[0]->subscribe == 1 )
            {
                $emailModel[0]->subscribe = 0;
                $emailModel[0]->save();
            }

            $emailModel2 = SubscribeUsers::findByAttributes( array( "email"=>$email ) );
            if( sizeof( $emailModel2 ) )
            {
                $emailModel2[0]->delete();
            }
            $this->render( "unSubscribe" );
        }
            else throw new CHttpException("Ошибка", Yii::t("page", "Неправильный адрес, проверьте адрес").".");
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