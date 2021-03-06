<?php

/**
 * This is the model class for table "catalog_firms".
   */
class CatalogFirmsAdd extends CatalogFirms
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, user_id, description, email, country_id, city_id, tel', 'required'),
			array('pos, del, tours_count, hotels_count, kurorts_count, service_count, col', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>150),
			array('image', 'length', 'max'=>100),
			array('email, www, tel, fax', 'length', 'max'=>50),
            array('name', 'duplicate'),
            array('date_edit, date_add, edit_date, name, user_id, description, pos, country_id, city_id, image, email, www, tel, fax, address, slug', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, pos, country_id, city_id, image, email, www, tel, del, tours_count, hotels_count, kurorts_count, service_count, fax, address, category_id, col, slug', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t("models", 'Название фирмы'),
            'image' => "Логотип компании",
            'country_id' => Yii::t("page", "Страна"),
            'city_id' => Yii::t("page", "Город"),
            'www' => 'Адресс сайта',
            'email' => 'Email',
            'tel' => Yii::t("models", "Телефон"),
            'fax' => Yii::t("models", "Факс" ),
            'address' => Yii::t("models", "Адрес" ),
            'description' => Yii::t("page", "Описание"),
        );
    }
}