<?php

/**
 * This is the model class for table "catalog_tours_en".
   */
class CatalogToursEn extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $srok; // string 
    protected $image; // string 
    protected $country_id; // integer 
    protected $city_id; // integer 
    protected $price; // string 
    protected $ltext; // string 
    protected $hot; // integer 
    protected $firm_id; // integer 
    protected $category_id; // integer 
    protected $vip; // string 
    protected $list_key; // string 
    protected $order_link; // string 
    protected $city_count; // integer 
    protected $firm_site_link; // string 
    protected $tour_per; // string 
    protected $hotel_id; // integer 
    protected $hotels_count; // integer 
    protected $col; // integer 
    protected $slug; // string 
    protected $user_id; // integer 
    protected $from_country_id; // integer

/*
* Поля - связи
*/


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_tours_en';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('active, pos, del, hot, city_count, hotel_id, hotels_count, col, from_country_id', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>150),
			array('srok, price', 'length', 'max'=>25),
			array('image', 'length', 'max'=>100),
			array('vip', 'length', 'max'=>1),
			array('order_link, firm_site_link', 'length', 'max'=>255),
			array('tour_per', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, del, srok, image, country_id, city_id, price, ltext, hot, firm_id, category_id, vip, list_key, order_link, city_count, firm_site_link, tour_per, hotel_id, hotels_count, col, slug, user_id, from_country_id', 'safe'),
            array('id, name, description, active, pos, del, srok, image, country_id, city_id, price, ltext, hot, firm_id, category_id, vip, list_key, order_link, city_count, firm_site_link, tour_per, hotel_id, hotels_count, col, slug, user_id, from_country_id', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
			'category' => array(self::BELONGS_TO, 'CatalogToursCategory', 'category_id'),
			'firm' => array(self::BELONGS_TO, 'CatalogFirms', 'firm_id'),
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
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
			'active' => 'Active',
			'pos' => 'Pos',
			'del' => 'Del',
			'srok' => 'Srok',
			'image' => 'Image',
			'country_id' => 'Country',
			'city_id' => 'City',
			'price' => 'Price',
			'ltext' => 'Ltext',
			'hot' => 'Hot',
			'firm_id' => 'Firm',
			'category_id' => 'Category',
			'vip' => 'Vip',
			'list_key' => 'List Key',
			'order_link' => 'Order Link',
			'city_count' => 'City Count',
			'firm_site_link' => 'Firm Site Link',
			'tour_per' => 'Tour Per',
			'hotel_id' => 'Hotel',
			'hotels_count' => 'Hotels Count',
			'col' => 'Col',
			'slug' => 'Slug',
			'user_id' => 'User',
			'from_country_id' => 'From Country',
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
		$criteria->compare('hot',$this->hot);
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('from_country_id',$this->from_country_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}