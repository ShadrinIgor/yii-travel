<?php

/**
 * This is the model class for table "catalog_kurorts".
   */
class CatalogKurortsAdd extends CatalogKurorts
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, category_id', 'required'),
			array('pos, del, firms_count, col', 'numerical', 'integerOnly'=>true),
			array('name, www, telefon, slug', 'length', 'max'=>150),
			array('image', 'length', 'max'=>100),
			array('email', 'length', 'max'=>50),
			array('price', 'length', 'max'=>25),
            array('category_id, country_id, city_id', 'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, description, pos, country_id, city_id, image, del, location, www, email, telefon, price, firms_count, col, category_id, slug', 'safe'),
            array('id, name, description, pos, country_id, city_id, image, del, location, www, email, telefon, price, firms_count, col, category_id, slug', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'pos' => 'Pos',
			'country_id' => 'Страна',
			'city_id' => 'Город',
			'image' => 'Image',
			'del' => 'Del',
			'location' => 'Location',
			'www' => 'Www',
			'email' => 'Email',
			'telefon' => 'Telefon',
			'price' => 'Price',
			'firms_count' => 'Firms Count',
			'col' => 'Col',
			'category_id' => 'Категория',
		);
	}
}