<?php

class DefaultController extends ConsoleController
{
    public function actions(){

//        Yii::import('application.extensions.kcaptcha.KCaptchaAction');
//        Yii::app()->session->remove(KCaptchaAction::SESSION_KEY);

        return array(
            'captcha'=>array(
                'class' => 'application.extensions.kcaptcha.KCaptchaAction',
                'maxLength' => 6,
                'minLength' => 5,
                'foreColor' => array(mt_rand(0, 100), mt_rand(0, 100),mt_rand(0, 100)),
                'backColor' => array(mt_rand(200, 210), mt_rand(210, 220),mt_rand(220, 230))
            )
        );
    }
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if( Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Console авторизации";
            $this->actionLogin();
        }
            else
        {

            $list = CatLog::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "id DESC" )->setLimit(50)->setCache(0) );

            Yii::app()->page->title = "Административный кабинет";
            $this->render( "room", array( "listStat"=>$list ) );
        }
	}

    public function actionLogin()
    {
        if( Yii::app()->user->isGuest )
        {
            $user =  new CatalogUsersAuthConsole();
            if( !empty( $_POST["CatalogUsersAuthConsole"] ) )
            {
                Yii::app()->page->title = "Авторизация";
                $user->setAttributes( $_POST["CatalogUsersAuthConsole"] );

                if( $user->validate() )
                {
                    $identity=new UserIdentity($user->email,$user->password);
                    $identity->authenticate();
                    if( empty( $identity->errorMessage ) )
                    {
                        Yii::app()->user->login($identity);

                        // Опрпделяем первый вход человека в личны кабинет

                        if(!empty( Yii::app()->session['redirect'] ))
                        {
                            $redirectUrl = Yii::app()->session['redirect'];
                            Yii::app()->session['redirect'] = "";
                            $this->redirect( $redirectUrl );
                        }

                        $this->redirect( $this->createUrl( "/console" ) );
                    }
                    else
                        $user->addError( "Ошибка авторизации", $identity->errorMessage );
                }
            }

            $this->render('login',array('form'=>$user));
        }
        else
        {
            Yii::app()->page->title = "Административный кабинет";
            $this->render( "room", array(  ) );
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

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect( SiteHelper::createUrl("/console") );
    }


};