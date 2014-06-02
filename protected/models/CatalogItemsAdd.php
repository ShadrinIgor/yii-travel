<?php

/**
 * This is the model class for table "catalog_items".
   */
class CatalogItemsAdd extends CatalogItems
{
	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, user_id, category_id, type_id, time_id', 'required'),
            array('user_id, category_id, type_id, time_id, del, price, is_hot, date, pos, col', 'numerical', 'integerOnly'=>true),
            array('name, image', 'length', 'max'=>255),
            array('slug', 'length', 'max'=>150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, image, description, del, price, user_id, category_id, type_id, status_id, is_hot, date, city_id, pos, time_id, slug, col', 'safe', 'on'=>'search'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t("models", 'Заголовок'),
			'image' => Yii::t("models", "Фотография" ),
			'price' => Yii::t("models", "Стоимость" ),
			'type_id' => Yii::t("models", "Тип объявления" ),
            'category_id' => Yii::t("models", "Категория" ),
            'time_id' => Yii::t("models", "Время публикации" ),
            'telephon' => Yii::t("models", 'Телефон'),
            'email' => 'Email',
            'isq' => 'ICQ',
            'skype' => 'Skype',
            'www' => Yii::t("models", "Сайт" ),
            'description' => Yii::t("page", "Описание"),
		);
	}

}