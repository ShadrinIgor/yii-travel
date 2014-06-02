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
			'name' => Yii::t("models", "Название фирмы" ),
			'country_id' => Yii::t("page", "Страна"),
			'city_id' => Yii::t("page", "Город"),
			'email' => 'Email',
			'www' => 'Www',
			'tel' => Yii::t("models", "Телефон"),
			'fax' => Yii::t("models", "Факс" ),
			'address' => Yii::t("models", "Адрес" ),
			'category_id' => 'Category',
		);
	}
}