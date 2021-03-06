<?php

class DefaultController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if( Yii::app()->user->isGuest )
        {
            $this->actionLogin();
            Yii::app()->page->title = Yii::t("user", "Страница авторизации" );
        }
            else
        {
            // Скрываем нотификацию
            $hide = (int)Yii::app()->request->getParam("hide",0);
            if( $hide >0 )
            {
                $notificationModel = Notifications::fetch( $hide );
                if( $notificationModel->id >0 && $notificationModel->user_id->id == Yii::app()->user->id )
                {
                    $notificationModel->is_new = 0;
                    $notificationModel->save();
                }
            }

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

    // профиль для просмотра
    public function actionUserProfile()
    {
        $user_id = (int) Yii::app()->request->getParam("id", 0);

        if( !empty( $user_id) )
        {
            $user = CatalogUsers::fetch( $user_id );
            if( $user->id>0 )
            {
                Yii::app()->page->title = Yii::t("user", "Профиль");
                $user_tree = CatalogGardensTree::findByAttributes( array( "user_id"=>$user->id ) );
                $this->render('user_profile', array( "user"=>$user, "user_tree"=>$user_tree ));
            }
        }
    }


    // Профиль для редактирования
    public function actionProfile()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = Yii::t("user", "Профиль");
            $arrayCountry = array();
            $user = CatalogUsersProfile::fetch( Yii::app()->user->id );

            if( !empty( $_POST["save_profile"] ) )
            {
                $user->setAttributesFromArray( $_POST["CatalogUsersProfile"] );
                if( $user->save() )
                {
                    $user->formMessage = Yii::t("user", "Профиль пользователя успешно сохранен" );
                }
            }

            $listCoutnry = CatalogCountry::fetchAll();
            foreach( $listCoutnry as $key=>$data )
                $arrayCountry[ $data->id ] = $data->name;

            $this->render('profile', array( "form"=>$user, "arrayCountry"=>$arrayCountry ));
        }
            else
            {
                Yii::app()->session['redirect'] = SiteHelper::createUrl("/user/default/Profile");
                $this->redirect("/user");
            }
    }

    public function actionRegistration()
    {
        if( !Yii::app()->user->isGuest )$this->redirect( SiteHelper::createUrl("/user") );
        $successfully = SiteHelper::checkedVaribal( Yii::app()->request->getParam("successfully", "" ), "string" );

        $user =  new CatalogUsersRegistration();
        Yii::app()->page->title = Yii::t("user", "Регистрация" );

        if( !empty( $_POST["CatalogUsersRegistration"] ) )
        {
            $user->setAttributes( $_POST["CatalogUsersRegistration"] );

            // Если указан Email проверяем небыл ли он зарегетрирован ранее,
            // если был но не активировал аккаунт то предлогаем отправить ему сообщение с активацией заново
            if( $user->email )
            {
                $checkUser = CatalogUsers::findByAttributes( array("email"=>$user->email) );
                if( is_array( $checkUser ) && sizeof( $checkUser )>0 )
                {
                    if( $checkUser[0]->active == 0 )
                    {
                        $content = CatalogContent::fetchBySlug("registration_resend_activation");
                        if( $content && $content->id >0 )
                        {
                            $errorMessage = $content->description;
                            $errorMessage = str_replace("{link}", SiteHelper::createUrl("/user/default/resend", array("email"=>$user->email)),$errorMessage );
                        }
                            else $errorMessage = Yii::t("user", "Вы уже зарегистрировались ранее");

                        $user->addError( Yii::t("user", "Ошибка регистрации"), $errorMessage );
                    }
                }
            }

            if( $user->save() )
            {
                $user->onRegistration( new CModelEvent($user), array( ) );
                $this->redirect( $this->createUrl( "/user/default/registration", array( "successfully"=>$user->email ) ) );
            }
        }

        $arrayCountry = array();
        $listCoutnry = CatalogCountry::fetchAll();
        foreach( $listCoutnry as $key=>$data )
            $arrayCountry[ $data->id ] = $data->name;

        $title = "Регистрация";

        if( !empty( $successfully ) )$okMessage = "<b>".Yii::t("user", "Регистрация сохранена.</b><br/>В течении нескольких минут к Вам на почту придет письмо для подтверждения Email").
                                                    "<br/><br/><b>".Yii::t("user", "Письмо не пришло?")."</b><br/> <a href=\"".SiteHelper::createUrl( "/user/default/resend", array( "email"=>$successfully ) ) ."\">".Yii::t("user", "отправить заново письмо для подтверждения на ").$successfully."</a>
                                                    <br/><br/><b>".Yii::t("user", "Все равно не пришло?</b><br/>Это странно, тогда Вам необходимо будет написать, с Email который вы указали при регистрации, письмо в службу тех. поддержки")." <a href=\"mailto:".Yii::app()->params["supportEmail"]."\">".Yii::app()->params["supportEmail"]."</a><br/>".Yii::t("user", "Пример письма:<br/>Заголовок письма - У меня проблемы с регистрацией<br/>Текст сообщения - Разберитесь пожалуйста");
                                       else $okMessage=null;

        $this->render( "registration", array( "form"=>$user, "arrayCountry"=>$arrayCountry, "title"=>$title, "okMessage"=>$okMessage ) );
    }

    public function actionConfirm()
    {
        $error = true;
        $errorMessage = null;
        $sekretKey = SiteHelper::checkedVaribal( Yii::app()->request->getParam("confirm_key"), "string" );
        if( !empty( $sekretKey ) )
        {
            $registrationConfirm = CatalogUsersConfirm::findByAttributes( array( "confirm_key"=>$sekretKey ) );

            if( sizeof($registrationConfirm)>0 )
            {
                $user = $registrationConfirm[0]->user_id;
                $user->onRegistrationConfirm( new CModelEvent( $registrationConfirm[0] ) );
                $error = false;
            }
        }

        $this->render( "confirm", array( "error"=>$error, "error_message" => $errorMessage ) );
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $user =  new CatalogUsersAuth();
        if( !empty( $_POST["CatalogUsersAuth"] ) )
        {
            Yii::app()->page->title = Yii::t("user", "Авторизация");
            $user->setAttributes( $_POST["CatalogUsersAuth"] );

            if( $user->validate() )
            {
                $identity=new UserIdentity($user->email,$user->password);
                if($identity->authenticate())
                {
                    Yii::app()->user->login($identity);
                }

                Yii::app()->session["userFirstIn"] = true;
                $user->onLogin( new CModelEvent( CatalogUsers::fetch( Yii::app()->user->id ) ) );

                if( Yii::app()->session['redirect'] )
                {
                    $redirectUrl = Yii::app()->session['redirect'];
                    Yii::app()->session['redirect'] = "";
                    $this->redirect( $redirectUrl );
                }

                $this->redirect( $this->createUrl( "/user" ) );
            }
        }

        $this->render('login',array('form'=>$user));
	}

    /**
     * Displays the lost password page
     */
    public function actionLost()
    {
        $user =  new CatalogUsersLost();

        if( !empty( $_POST["CatalogUsersLost"] ) )
        {
            Yii::app()->page->title = Yii::t("user", "Забыли пароль");
            $user->setAttributes( $_POST["CatalogUsersLost"] );
            if( $user->validate() )
            {
                $userByEmail = CatalogUsers::findByAttributes( array("email"=>$user->email) );
                $user->onLostPassword( new CModelEvent( $userByEmail[0] ) );
                $this->redirect( $this->createUrl( "default/lost/successfully/" ) );
            }
        }

        if( isset( $_GET["successfully"] ) )$okMessage = "<b>".Yii::t("user", "Запрос на восстановление пароля сохранен.</b><br/>В течении нескольких минут к Вам на почту придет письмо для подтверждения запроса" )."</b>";
                                       else $okMessage=null;

        $this->render('lost',array('form'=>$user, "okMessage"=>$okMessage ));
    }


    /**
     * Displays the lost password page
     */
    public function actionLostConfirm()
    {
        $error = false;

        $lostConfirm = new CatalogUsersLost();
        $formNewsPassword = new CatalogUsersLostConfirm();

        $key = Yii::app()->request->getParam("key", "");
        if( !empty( $key ) && !isset( $_GET["successfully"] ) )
        {
            $lostConfirm = CatalogUsersConfirm::findByAttributes( array( "confirm_key"=>$key) );

            if( empty( $lostConfirm ) || sizeof( $lostConfirm ) == 0 )$error = true;
        }
            else $error = true;

        if( empty( $error ) && !empty( $_POST["CatalogUsersLostConfirm"] ) )
        {
            $formNewsPassword = new CatalogUsersLostConfirm();
            $formNewsPassword->setAttributesFromArray( $_POST["CatalogUsersLostConfirm"] );

            if( $formNewsPassword->validate() )
            {
                $formNewsPassword->onLostPasswordConfirm( new CModelEvent( $lostConfirm ) );
                $this->redirect( $this->createUrl( "default/lostconfirm/successfully/" ) );
            }
        }

        if( isset( $_GET["successfully"] ) )
        {
            $error = false;
            $okMessage = "<b>Новый пароль успешно сохранен.</b><br/>Вы можете авторизоваться используя новый пароль";
        }
            else $okMessage=null;

        $this->render('lostconfirm',array( 'key'=>$key,'form'=>$lostConfirm, 'formNewsPassword'=>$formNewsPassword, "error"=>$error, "okMessage"=>$okMessage));
    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionTerm()
    {
        $text = CatalogContent::fetchBySlug("site_rules");
        if( !empty( $text ) && $text->id>0 )
            $this->render("term", array( "text"=>$text ));
    }

    public function actionResend()
    {
        $email = SiteHelper::checkedVaribal( Yii::app()->request->getParam("email", "" ), "string" );

        if( !empty( $email ) )
        {
            $userModel = CatalogUsers::findByAttributes( array( "email" => $email ) );
            if( is_array($userModel) && sizeof($userModel)>0 && $userModel[0]->active == 0 )
            {
                $userModel[0]->onRegistration( new CModelEvent($userModel[0]), array( ) );
                $this->render( "resend", array("user"=>$userModel) );
            }
        }

//        die;
        $this->redirect( SiteHelper::createUrl( "/user" ) );
    }

    public function actionNotificationHide()
    {
        $id = (int)Yii::app()->request->getParam("id", 0 );
        $notification = Notifications::fetch( $id );

        if( $notification->id >0 && $notification->user_id->id == Yii::app()->user->getId() )
        {
            echo $notification->id;
            $notification->is_new = 0;
            $notification->save();

            return;
        }
        echo 0;
        return ;
    }
};