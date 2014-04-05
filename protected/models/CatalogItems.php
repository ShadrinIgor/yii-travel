<?php

/**
 * This is the model class for table "catalog_items".
   */
class CatalogItems extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $image; // string 
    protected $description; // string 
    protected $del; // integer 
    protected $price; // integer 
    protected $user_id; // integer 
    protected $category_id; // integer 
    protected $type_id; // integer 
    protected $status_id; // integer 
    protected $is_hot; // integer 
    protected $date; // integer 
    protected $city_id; // integer 
    protected $pos; // integer 
    protected $time_id; // integer 

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
		return 'catalog_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, user_id, type_id', 'required'),
			array('del, price, is_hot, date, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, description, del, price, user_id, category_id, type_id, status_id, is_hot, date, city_id, pos, time_id', 'safe'),
            array('id, name, image, description, del, price, user_id, category_id, type_id, status_id, is_hot, date, city_id, pos, time_id', 'safe', 'on'=>'search'),
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
			'time' => array(self::BELONGS_TO, 'CatalogItemsTime', 'time_id'),
			'category' => array(self::BELONGS_TO, 'CatalogItemsCategory', 'category_id'),
			'status' => array(self::BELONGS_TO, 'CatalogItemsStatus', 'status_id'),
			'type' => array(self::BELONGS_TO, 'CatalogItemsType', 'type_id'),
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
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
			'del' => 'Del',
			'price' => 'Price',
			'user_id' => 'User',
			'category_id' => 'Category',
			'type_id' => 'Type',
			'status_id' => 'Status',
			'is_hot' => 'Is Hot',
			'date' => 'Date',
			'city_id' => 'City',
			'pos' => 'Pos',
			'time_id' => 'Time',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('price',$this->price);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('is_hot',$this->is_hot);
		$criteria->compare('date',$this->date);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('time_id',$this->time_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}