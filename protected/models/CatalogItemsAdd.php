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
			array('category_id, time_id, user_id, name, description, type_id', 'required'),
			array('category_id, time_id, user_id, type_idб del, price, is_hot, date, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('image', 'length', 'max'=>255),
            array('col, slug, time_id, name, image, description, del, price, user_id, category_id, type_id, status_id, is_hot, date, city_id, pos', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, description, del, price, user_id, category_id, type_id, status_id, is_hot, date, city_id, pos', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Загоовк',
			'image' => 'Фотография',
			'price' => 'Стоимость',
			'type_id' => 'Тип объявления',
            'category_id' => 'Категория',
            'time_id' => 'Время публикации',
            'description' => 'Описание',
		);
	}

}