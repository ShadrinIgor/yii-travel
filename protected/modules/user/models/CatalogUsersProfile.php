<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersProfile extends CatalogUsers
{
    protected $password2;
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t("models", "Имя" ),
            'password' => Yii::t("models", "Пароль" ),
            'password2' => Yii::t("models", "Подтверждение пароля" ),
//            'surname' => 'Фамилия',
//            'fatchname' => 'Отчество',
            'email' => 'Email',
            'country_id' => Yii::t("page", "Страна"),
            'city_id' => Yii::t("models", "Город" ),
//            'image' => 'Фото пользователя',
//            'country_other' => 'Другая страна',
            'phone' => Yii::t("models", "Сотовый" ),
//            'site' => 'Сайт',
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country_id0' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
            'city_id0' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
        );
    }

 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

            array('type_id', 'setDefaultType'),

			array('name, password, password2', 'required'),
            array('password', 'compare', 'compareAttribute'=>'password2'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'maxSize' => 1048576, 'wrongType'=>'Неправельный тип загружаемого файла', 'tooLarge'=>'Ограничение размера загрузки файла 2mb'),
            /*
             *   авторизованным пользователям код можно не вводить
                'allowEmpty'=>!Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
             */
			array('name', 'length', 'max'=>35),
			array('password, image', 'length', 'max'=>255),
			array('surname', 'length', 'max'=>25),
            array('password', 'updatePasswordHashMD5'),
            array('image', 'uploadImage'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('name, password, surname, country_id, city_id, image, country_other, phone', 'safe'),
		);
	}

}