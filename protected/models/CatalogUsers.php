<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsers extends CCmodel
{
    protected $id; // integer 
    protected $del; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $password; // string 
    protected $surname; // string 
    protected $fatchname; // string 
    protected $email; // string 
    protected $country; // integer 
    protected $city; // integer 
    protected $type_id; // integer 
    protected $image; // string 
    protected $country_other; // string 
    protected $last_visit; // integer 
    protected $phone; // string 
    protected $site; // string 
    protected $quote; // string 
    protected $desktop; // integer 
    protected $amount; // integer 

/*
* Поля - связи
*/
    protected $catalogItems; //  CatalogItems
    protected $favorites; //  Favorites
    protected $notifications; //  Notifications
    protected $orderRequests; //  OrderRequest


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, password, email, type_id', 'required'),
			array('del, active, last_visit, amount', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>35),
			array('password, image', 'length', 'max'=>255),
			array('surname, fatchname', 'length', 'max'=>25),
			array('email', 'length', 'max'=>50),
			array('country_other, phone, site', 'length', 'max'=>150),
			array('quote', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, del, name, active, password, surname, fatchname, email, country, city, type_id, image, country_other, last_visit, phone, site, quote, desktop, amount', 'safe', 'on'=>'search'),
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
			'catalogItems' => array(self::HAS_MANY, 'CatalogItems', 'user_id'),
			'country0' => array(self::BELONGS_TO, 'CatalogCountry', 'country'),
			'type' => array(self::BELONGS_TO, 'CatalogUsersType', 'type_id'),
			'desktop0' => array(self::BELONGS_TO, 'CatalogDesktops', 'desktop'),
			'city0' => array(self::BELONGS_TO, 'CatalogCity', 'city'),
			'favorites' => array(self::HAS_MANY, 'Favorites', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Notifications', 'user_id'),
			'orderRequests' => array(self::HAS_MANY, 'OrderRequest', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'del' => 'Del',
			'name' => 'Name',
			'active' => 'Active',
			'password' => 'Password',
			'surname' => 'Surname',
			'fatchname' => 'Fatchname',
			'email' => 'Email',
			'country' => 'Country',
			'city' => 'City',
			'type_id' => 'Type',
			'image' => 'Image',
			'country_other' => 'Country Other',
			'last_visit' => 'Last Visit',
			'phone' => 'Phone',
			'site' => 'Site',
			'quote' => 'Quote',
			'desktop' => 'Desktop',
			'amount' => 'Amount',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('fatchname',$this->fatchname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('country',$this->country);
		$criteria->compare('city',$this->city);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('country_other',$this->country_other,true);
		$criteria->compare('last_visit',$this->last_visit);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('quote',$this->quote,true);
		$criteria->compare('desktop',$this->desktop);
		$criteria->compare('amount',$this->amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}