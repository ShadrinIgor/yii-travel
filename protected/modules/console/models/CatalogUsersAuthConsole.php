<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersAuthConsole extends CatalogUsers
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
            array('type_id', 'check_type'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('last_visit', 'safe'),
		);
	}

    public function check_type($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $user = CatalogUsers::findByAttributes(array("email"=>$this->email, "password"=>md5( $this->password )));

            $consoleType = CatalogUsersType::fetchByKeyWord("console");
            if( $user[0]->type_id != $consoleType->id )
            {
                $this->addErrors( array( "0"=>"У вас нет доступа для данного раздела" ) );
            }
        }
    }

    public function check_exists_params($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $identity=new UserIdentity($this->email,$this->password);
            $errorCode = $identity->authenticate();

            if( !empty( $errorCode ) )
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'del' => 'Del',
            'name' => 'Name',
            'active' => 'Active',
            'password' => 'Password',
            'surname' => 'Surname',
            'fathname' => 'Father name',
            'email' => 'Email',
            'country' => 'Country',
            'city' => 'City',
            'type_id' => 'Type',
            'image' => 'Image',
            'country_other' => 'Country Other',
        );
    }

}