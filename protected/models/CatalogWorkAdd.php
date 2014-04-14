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
            array('name, description, category_id, user_id, type_id, contacts, graf', 'required'),
            array('user_id, type_id, price, del, pos, is_resume, date, active', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>150),
            array('image', 'length', 'max'=>255),
            array('col, slug, type_id, name, image, description, contacts, price, graf, city_id, del, pos, category_id, is_resume, user_id, firm_id, date, country_id, active', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, image, description, contacts, price, graf, city_id, del, pos, category_id, is_resume, user_id, firm_id, date, country_id, active', 'safe', 'on'=>'search'),
        );
    }

    public function attributePlaceholder()
    {
        return array(
            'name' => 'например: Требуется опытный бухгалтер',
            'contacts' => 'тут необходимо указать контактные телефоны',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Название вакансии',
            'category_id' => 'Кактегория вакансии',
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'image' => 'Фото',
            'graf' => 'График',
            'price' => 'Заработная плата',
            'contacts' => 'Контакты',
            'description' => 'Описание вакансии',
        );
    }
}