<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersAuth extends CatalogUsers
{
    var $captcha;
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('email, password, captcha', 'required'),
			array('password', 'length', 'max'=>255),
            array('email', 'check_exists_params'),
            array( 'captcha', 'captcha' ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('email, password, last_visit', 'safe'),
		);
	}

    public function attributeLabels()
    {
        return array(
            'email' => 'email',
            'password' => 'Пароль',
        );
    }

    public function check_exists_email()
    {}

    public function check_exists_params($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $identity=new UserIdentity($this->email,$this->password);
            $errorCode = $identity->authenticate();

            if( $errorCode == 0 )
                Yii::app()->user->login($identity);
            else
            {
                if( $errorCode == 100 )
                {
                    $textError = "Вы не подтвердили Свой Email:".$this->email."<br/>";
                    $textError .= "Вам по почте должно было прийти письмо для подверждения регистрации.
                                                   <br/><br/><b>Письмо не пришло?</b><br/><a href=\"".SiteHelper::createUrl( "/user/default/resend", array( "email"=>$this->email ) ) ."\">отправить заново письмо для подтверждения регистрации на ".$this->email."</a>
                                                   <br/><br/><b>Все равно не пришло?</b><br/>Это странно, тогда Вам необходимо будет написать, с Email который вы указали при регистрации, письмо в службу тех. потдержки <a href=\"mailto:".Yii::app()->params["supportEmail"]."\">".Yii::app()->params["supportEmail"]."</a><br/>Пример письма:<br/>Заголовок письма - У меня проблемы с регистрацией<br/>Текст сообщения - Разберитесь пожалуйста";
                    $this->addErrors( array(  "0"=>$textError ) );
                }
                    else
                {
                    $textError = "Вы ввели не верный Email или ПАРОЛЬ<br/>";
                    $textError .= "<br/><b>Забыли пароль?</b><br/><a href=\"".SiteHelper::createUrl( "/user/default/lost" ) ."\">востановить пароль</a>";
                    $this->addErrors( array(  "0"=>$textError ) );
                }
            }
        }
    }

}