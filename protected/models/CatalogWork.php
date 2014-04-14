<?php

/**
 * This is the model class for table "catalog_work".
   */
class CatalogWork extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $image; // string 
    protected $description; // string 
    protected $contacts; // string 
    protected $price; // integer 
    protected $graf; // integer 
    protected $city_id; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $category_id; // integer 
    protected $is_resume; // integer 
    protected $user_id; // integer 
    protected $firm_id; // integer 
    protected $date; // integer 
    protected $country_id; // integer 
    protected $active; // integer 
    protected $type_id; // integer
    protected $slug;
    protected $col;

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
		return 'catalog_work';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, category_id, user_id, type_id', 'required'),
			array('price, del, pos, is_resume, date, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('image', 'length', 'max'=>255),
			array('contacts, active', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, description, contacts, price, graf, city_id, del, pos, category_id, is_resume, user_id, firm_id, date, country_id, active, type_id', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'CatalogWorkType', 'type_id'),
			'graf0' => array(self::BELONGS_TO, 'CatalogWorkGraf', 'graf'),
			'category' => array(self::BELONGS_TO, 'CatalogWorkCategory', 'category_id'),
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
			'firm' => array(self::BELONGS_TO, 'CatalogFirms', 'firm_id'),
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
			'image' => 'Image',
			'description' => 'Description',
			'contacts' => 'Contacts',
			'price' => 'Price',
			'graf' => 'Graf',
			'city_id' => 'City',
			'del' => 'Del',
			'pos' => 'Pos',
			'category_id' => 'Category',
			'is_resume' => 'Is Resume',
			'user_id' => 'User',
			'firm_id' => 'Firm',
			'date' => 'Date',
			'country_id' => 'Country',
			'active' => 'Is Active',
			'type_id' => 'Type',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('contacts',$this->contacts,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('graf',$this->graf);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('is_resume',$this->is_resume);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('type_id',$this->type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}