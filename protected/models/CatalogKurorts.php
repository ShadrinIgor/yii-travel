<?php

/**
 * This is the model class for table "catalog_kurorts".
   */
class CatalogKurorts extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $country_id; // integer 
    protected $city_id; // integer 
    protected $image; // string 
    protected $del; // integer 
    protected $ltext; // string 
    protected $location; // string 
    protected $www; // string 
    protected $email; // string 
    protected $telefon; // string 
    protected $price; // string 
    protected $firms_count; // integer 
    protected $col; // integer 
    protected $category_id; // integer 

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
		return 'catalog_kurorts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, image, ltext, location, www, email, telefon, price, category_id', 'required'),
			array('active, pos, del, firms_count, col, category_id, country_id, city_id', 'numerical', 'integerOnly'=>true),
			array('name, www, telefon', 'length', 'max'=>150),
			array('image', 'length', 'max'=>100),
			array('email', 'length', 'max'=>50),
			array('price', 'length', 'max'=>25),
            array('category_id, country_id, city_id', 'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, country_id, city_id, image, del, ltext, location, www, email, telefon, price, firms_count, col, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'CatalogKurortsCategory', 'category_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
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
			'country_id' => 'Страна',
			'city_id' => 'Город',
			'image' => 'Image',
			'del' => 'Del',
			'ltext' => 'Ltext',
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('ltext',$this->ltext,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('www',$this->www,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('firms_count',$this->firms_count);
		$criteria->compare('col',$this->col);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}