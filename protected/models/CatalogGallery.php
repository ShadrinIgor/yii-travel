<?php

/**
 * This is the model class for table "catalog_gallery".
   */
class CatalogGallery extends CCmodel
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
    protected $cat_id; // string 
    protected $tour_cid; // string 

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
		return 'catalog_gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, image, cat_id, tour_cid', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('image', 'length', 'max'=>100),
			array('cat_id, tour_cid', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, country_id, city_id, image, del, cat_id, tour_cid', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
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
			'country_id' => 'Country',
			'city_id' => 'City',
			'image' => 'Image',
			'del' => 'Del',
			'cat_id' => 'Cat',
			'tour_cid' => 'Tour Cid',
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
		$criteria->compare('cat_id',$this->cat_id,true);
		$criteria->compare('tour_cid',$this->tour_cid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}