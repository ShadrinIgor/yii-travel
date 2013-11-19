<?php

/**
 * This is the model class for table "catalog_work".
   */
class CatalogWorkAdd extends CatalogWork
{

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category_id, user_id, description', 'required'),
			array('category_id, city, del, pos, is_resume, is_resume, user_id, firm_id, country_id, is_active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('is_active, date, name, image, description, contacts, price, graf, country_id, city, del, pos, category_id, is_resume, user_id, firm_id', 'safe'),
			array('id, name, image, description, contacts, price, graf, city, del, pos, category_id, is_resume, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'category_id' => 'Категория',
            'country_id' => 'Страна',
            'city' => 'Город',
			'name' => 'Заголовок',
            'graf' => 'График работы',
            'price' => 'Зарплата',
			'image' => 'Фото',
			'description' => 'Описание',
			'contacts' => 'Контактная информация',
            'is_active' => 'Опубликовать',
		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "price"=>"varchar", "is_active"=>"checkbox" ) );
    }
}