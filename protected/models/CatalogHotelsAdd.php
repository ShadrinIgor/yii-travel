<?php

/**
 * This is the model class for table "catalog_hotels".
   */
class CatalogHotelsAdd extends CatalogHotels
{
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, country_id, city_id, user_id, email, tel', 'required'),
            array('pos, del, level, col, country_id, city_id, user_id, is_active', 'numerical', 'integerOnly'=>true),
            array('name, image', 'length', 'max'=>100),
            array('level', 'length', 'max'=>25),
            array('email, www, fax, tel, slug', 'length', 'max'=>150),
            array('country_id, city_id, level', 'search'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, name, description, pos, country_id, city_id, address, del, image, level, email, www, fax, tel, col, slug', 'safe'),
            array('id, name, description, pos, country_id, city_id, address, del, image, level, email, www, fax, tel, col, slug, user_id, is_active', 'safe', 'on'=>'search'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t("models", "Название"),
			'country_id' => Yii::t("page", "Страна"),
			'city_id' => Yii::t("page", "Город"),
			'address' => Yii::t("models", "адрес" ),
			'level' => Yii::t("models", "Кол. звезд" ),
			'email' => 'Email',
			'www' => Yii::t("models", "Сайт" ),
			'fax' => Yii::t("models", "Факс" ),
			'tel' => Yii::t("models", "Телефон"),
            'description' => Yii::t("page", "Описание"),
		);
	}
}