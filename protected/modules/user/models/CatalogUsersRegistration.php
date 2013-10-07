<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersRegistration extends CatalogUsers
{
    protected $password2; // string
    protected $captcha; //string
    protected $term; //integer
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

            array('type_id', 'setDefaultType'),
            array('active', 'setDefaultActive'),
            array('term', 'checkTerm'),

			array('name, password, password2, email, captcha, type_id', 'required'),
            array('password', 'compare', 'compareAttribute'=>'password2'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'maxSize' => 1048576, 'wrongType'=>'Неправельный тип загружаемого файла', 'tooLarge'=>'Ограничение размера загрузки файла 2mb'),
            array( 'captcha', 'captcha' ),
            /*
             *   авторизованным пользователям код можно не вводить
                'allowEmpty'=>!Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
             */
			array('active, type_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>35),
			array('password, image', 'length', 'max'=>255),
			array('surname, fatchname', 'length', 'max'=>25),
            array('email', 'email', 'checkMX'=>true ),
            array('email', 'check_exists_email'),
            array('password', 'passwordHashMD5'),
            array('image', 'uploadImage'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('name, password, surname, fatchname, email, country, city, image, country_other, type_id, active, last_visit', 'safe'),
		);
	}

    public function checkTerm( $attribute,$params )
    {
        if( !$this->hasErrors() && empty( $this->term ) )
        {
            $this->addErrors( array(  "0"=>"Вы не согласились с правилами" ) );
        }
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country0' => array(self::BELONGS_TO, 'CatalogCountry', 'country'),
            'city0' => array(self::BELONGS_TO, 'CatalogCity', 'city'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Имя',
            'password' => 'Пароль',
            'password2' => 'Подтверждение пароля',
//            'surname' => 'Фамилия',
//            'fatchname' => 'Отчество',
            'email' => 'Email',
            'country' => 'Страна',
            'city' => 'Город',
//            'image' => 'Фото пользователя',
//            'country_other' => 'Другая страна',
            'phone' => 'Сотовый',
//            'site' => 'Сайт',
        );
    }
}