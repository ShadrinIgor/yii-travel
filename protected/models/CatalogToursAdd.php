<?php

/**
 * This is the model class for table "catalog_tours".
   */
class CatalogToursAdd extends CatalogTours
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category_id, country_id, firm_id, duration , description, included, program, price, currency_id', 'required'),
			array('is_newyear, currency_id, price, category_id, country_id, city_id, firm_id, active, pos, del, city_count, hotel_id, hotels_count, col', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('srok, price', 'length', 'max'=>25),
			array('image', 'length', 'max'=>100),
			array('hot, vip', 'length', 'max'=>1),
			array('order_link, firm_site_link', 'length', 'max'=>255),
			array('tour_per', 'length', 'max'=>50),
            array('firm_id, category_id, country_id, price', 'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.

			array('dates, is_newyear, date_edit, date_add, currency_id, duration, attention, cancellation, not_included, included, prices, program, slug, name, description, active, pos, del, srok, image, country_id, city_id, price, ltext, hot, firm_id, category_id, vip, list_key, order_link, city_count, firm_site_link, tour_per, hotel_id, hotels_count, col', 'safe'),
			array('id, name, description, active, pos, del, srok, image, country_id, city_id, price, ltext, hot, firm_id, category_id, vip, list_key, order_link, city_count, firm_site_link, tour_per, hotel_id, hotels_count, col', 'safe', 'on'=>'search'),
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
			'firm' => array(self::BELONGS_TO, 'CatalogFirms', 'firm_id'),
            'currency' => array(self::BELONGS_TO, 'CatalogCurrency', 'currency_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
			'category' => array(self::BELONGS_TO, 'CatalogToursCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t("models", "Название"),
			"is_newyear" => "Новогоднее предложение",
            'category_id' => Yii::t("models", "Категория" ),
			//'active' => 'Активный тур<br/><i>( поставте галочку если необходимо опубликавать тур на сайте )</i>',
            'hot' => Yii::t("page", 'Горячий тур'),
			'country_id' => Yii::t("page", 'Страна тура'),
			'city_id' => Yii::t("page", "Город"),
            'duration' => 'Длительноть тура',
            'price' => "Цена от",
            'prices' => "Описание цен ( в зависимости от количество и людей и т.д. )",
            'currency_id' => "Укажите валюту",
            'description' => Yii::t("page", 'Описание тура'),
			'dates' => 'Период действия предложения',
            'program' => 'Программа тура',
            'included' => 'В тур включенно',
            'not_included' => 'В тур НЕ включенно',
            'attention' => 'Внимание',
            'cancellation' => 'Условия ануляции',

		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(),
                                array("price"=>"integer", "hot" => "checkbox", "is_newyear" => "checkbox")
                    );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('srok',$this->srok,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('ltext',$this->ltext,true);
		$criteria->compare('hot',$this->hot,true);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('vip',$this->vip,true);
		$criteria->compare('list_key',$this->list_key,true);
		$criteria->compare('order_link',$this->order_link,true);
		$criteria->compare('city_count',$this->city_count);
		$criteria->compare('firm_site_link',$this->firm_site_link,true);
		$criteria->compare('tour_per',$this->tour_per,true);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('hotels_count',$this->hotels_count);
		$criteria->compare('col',$this->col);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}