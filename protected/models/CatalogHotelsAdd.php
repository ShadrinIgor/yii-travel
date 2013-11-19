<?php

/**
 * This is the model class for table "catalog_hotels".
   */
class CatalogHotelsAdd extends CatalogHotels
{
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Название',
			'country_id' => 'Страна',
			'city_id' => 'Город',
			'address' => 'Адресс',
			'image' => 'Фото',
			'level' => 'Кол. звезд',
			'email' => 'Email',
			'www' => 'Сайт',
			'fax' => 'Факс',
			'tel' => 'Телефон',
            'description' => 'Описание',
			'is_active' => 'опубликовано',
		);
	}
}