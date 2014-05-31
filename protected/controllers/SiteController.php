<?php

class SiteController extends Controller
{

    /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
    static function getSubTextOnWorld2( $text, $count, $from = 0 )
    {
        $cout = "";
        for( $i=0;$i<$count;$i++ ) //  strlen( $text )>$count )
        {
            if( $i+$from>= strlen( $text ) ) break;
            $cout .= $text[$i+$from];
        }

        return $cout;
    }

    public function translate()
    {
        $model = CatalogFirms::fetch( 17 );
        echo $model->description."<hr/><br/>";

        $step = 0;
        $cout = "";
        for( $n=0;$n<strlen( $model->description );$n+=800 )
        {
            $text = $this->getSubTextOnWorld2( $model->description, 800, $n );
            $text = str_replace( array( "\n", "\r" ), "" , $text );
            // echo $text."<hr/>";


            $file = file_get_contents( "http://translate.google.ru/translate_a/t?client=x&text=".urlencode( $text )."&hl=ru&sl=ru&tl=en&ie=UTF-8&oe=UTF-8" );

            $res = json_decode( $file );
            if( json_last_error() >0 )
                echo "Error: ".json_last_error()."<br/>";

            $text = "";
            for( $i=0;$i<sizeof( $res->sentences );$i++ )
                $text .= $res->sentences[$i]->trans;

            $text = str_replace( "< /", "</", $text );
            $text = str_replace( "</ ", "</", $text );
            $cout .= $text;
        }
        echo "<hr/>".$cout."*";
    }

	public function actionIndex()
	{
        //$this->translate();

        //SiteHelper::mailto( "Привет Чулик", "info@world-travel.uz", "shadrin.igor@gmail.com", "Тут будет текст сообщения. Тут будет текст сообщения. " );
/*
        $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?' .
            'key=ce1590bf92736d0a.67102eeed7aa4dddb3e58fd511568d4ad8e8e49b' .
            'text=My name is Igor&' .
            'lang=en-ru&' .
            'format=plain&' .
            'options=1';

        $curlObject = curl_init();

        curl_setopt($curlObject, CURLOPT_URL, $url);

        curl_setopt($curlObject, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlObject, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);

        $responseData = curl_exec($curlObject);

        curl_close($curlObject);

        if ($responseData === false) {
            throw new Exception('Response false');
        }

        var_dump(json_decode($responseData, true));*/
        //die;
        Yii::app()->page->title = "Туристический портал Узбекистана, отдых, туры, туроператоры, путешествия, турция, анталия, узбекистан";
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
            else throw new CHttpException("Ошибка","Неправельный адресс, проверьте адррес.");
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