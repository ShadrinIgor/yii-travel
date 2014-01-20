<?php

/**
 * This is the model class for table "catalog_firms".
   */
class CatalogFirmsInfo extends CatalogFirms
{

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Название фирмы',
			'country_id' => 'Страна',
			'city_id' => 'Город',
			'email' => 'Email',
			'www' => 'Www',
			'tel' => 'Телефон',
			'fax' => 'Факс',
			'address' => 'Адрес',
			'category_id' => 'Category',
		);
	}
}