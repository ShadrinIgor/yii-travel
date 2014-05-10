<?php

/**
 * This is the model class for table "catalog_cooperation".
   */
class CatalogCooperation extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $image; // string 
    protected $category_id; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $country_id; // integer 
    protected $slug; // string 

/*
* Поля - связи
*/
    protected $catalogCountries; //  CatalogCountry


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_cooperation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, category_id', 'required'),
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('image', 'length', 'max'=>255),
			array('slug', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, description, image, category_id, pos, del, country_id, slug', 'safe'),
            array('id, name, description, image, category_id, pos, del, country_id, slug', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'CatalogCooperationCategory', 'category_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'catalogCountries' => array(self::HAS_MANY, 'CatalogCountry', 'cooperation_id'),
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
			'image' => 'Image',
			'category_id' => 'Category',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}