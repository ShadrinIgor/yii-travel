<?php

/**
 * This is the model class for table "catalog_items".
   */
class CatalogItemsAdd2 extends CatalogItems2
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, category_id, user_id, type_id, city_id', 'required'),
			array('del, price, is_hot, city_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('image', 'length', 'max'=>255),
			array('city_id, name, image, description, price, category_id, user_id, type_id, date, status_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, description, del, price, user_id, category_id, type_id, status_id, is_hot', 'safe', 'on'=>'search'),
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
            'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
            'category' => array(self::BELONGS_TO, 'CatalogItemsCategory', 'category_id'),
            'type' => array(self::BELONGS_TO, 'CatalogItemsType', 'type_id'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'name' => 'Заговок объявления',
            'city_id' => 'Город',
            'description' => 'Дополнительное описание',
            'price' => 'Цена',
			'category_id' => 'Категория',
			'type_id' => 'Тип',
		);
	}
}