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
            array('name, description, category_id, country_id, city_id, user_id, telefon', 'required'),
            array('user_id, pos, del, firms_count, col', 'numerical', 'integerOnly'=>true),
            array('name, www, telefon, slug', 'length', 'max'=>150),
            array('image', 'length', 'max'=>100),
            array('email', 'length', 'max'=>50),
            array('price', 'length', 'max'=>25),
            array('name', 'duplicate'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, description, country_id, city_id, image, location, www, email, telefon, price, category_id, slug, user_id', 'safe'),
            array('id, name, description, pos, country_id, city_id, image, del, location, www, email, telefon, price, firms_count, col, category_id, slug, user_id', 'safe', 'on'=>'search'),
        );
    }

     /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t("models", "Название"),
            'category_id' => Yii::t("models", "Категория" ),
            'country_id' => Yii::t("page", "Страна"),
            'city_id' => Yii::t("page", "Город"),
            'location' => Yii::t("models", "Адресс" ),
            'www' => Yii::t("models", "Сайт" ),
            'email' => 'Email',
            'telefon' => Yii::t("models", "Телефон"),
            'price' => Yii::t("models", "Цена" ),
            'description' => Yii::t("page", "Описание"),
        );
    }
}