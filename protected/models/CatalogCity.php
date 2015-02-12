<?php

/**
 * This is the model class for table "catalog_city".
   */
class CatalogCity extends CCModel
{
    protected $id; // integer 
    protected $name; // string
    protected $name2; // string
    protected $pos; // integer 
    protected $country_id; // integer 
    protected $del; // integer 
    protected $description; // string 
    protected $slug; // string
    protected $translate; // string

/*
* Поля - связи
*/
    protected $catalogFirms; //  CatalogFirms
    protected $catalogGalleries; //  CatalogGallery
    protected $catalogHotels; //  CatalogHotels
    protected $catalogInfos; //  CatalogInfo
    protected $catalogItems; //  CatalogItems
    protected $catalogKurorts; //  CatalogKurorts
    protected $catalogMonuments; //  CatalogMonuments
    protected $catalogTours; //  CatalogTours
    protected $catalogUsers; //  CatalogUsers


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>25),
			array('slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('translate, id, name, pos, country_id, del, description, slug', 'safe'),
            array('translate, id, name, pos, country_id, del, description, slug', 'safe', 'on'=>'search'),
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
			'catalogFirms' => array(self::HAS_MANY, 'CatalogFirms', 'city_id'),
			'catalogGalleries' => array(self::HAS_MANY, 'CatalogGallery', 'city_id'),
			'catalogHotels' => array(self::HAS_MANY, 'CatalogHotels', 'city_id'),
			'catalogInfos' => array(self::HAS_MANY, 'CatalogInfo', 'city_id'),
			'catalogItems' => array(self::HAS_MANY, 'CatalogItems', 'city_id'),
			'catalogKurorts' => array(self::HAS_MANY, 'CatalogKurorts', 'city_id'),
			'catalogMonuments' => array(self::HAS_MANY, 'CatalogMonuments', 'city_id'),
			'catalogTours' => array(self::HAS_MANY, 'CatalogTours', 'city_id'),
			'catalogUsers' => array(self::HAS_MANY, 'CatalogUsers', 'city'),
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
			'pos' => 'Pos',
			'country_id' => 'Country',
			'del' => 'Del',
			'description' => 'Description',
			'slug' => 'Slug',
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
		$criteria->compare('pos',$this->pos);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}