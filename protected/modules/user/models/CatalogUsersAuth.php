<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersAuth extends CatalogUsers
{
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('email, password', 'required'),
			array('password', 'length', 'max'=>255),
            array('email', 'check_exists_params'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('last_visit', 'safe'),
		);
	}

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
                switch( $errorCode )
                {
                    case 1:
                    case 2: $error = "Вы ввели неверный EMAIL или ПАРОЛЬ";break;
                    case 100 :$error = "Ваш аккаунт не активный, Вы не подтвердили регистрацию";break;
                    default : $error = "Вы ввели неверный EMAIL или ПАРОЛЬ";
                }
                $this->addErrors( array( "0"=>$error ) );
            }
        }
    }

}