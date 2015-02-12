<?php

/**
 * This is the model class for table "catalog_attractions".
   */
class CatalogAttractions extends CActiveRecord
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $tags; // string 
    protected $city_id; // integer 
    protected $image; // string 
    protected $country_id; // integer 
    protected $slug; // string 
    protected $del; // integer 
    protected $pos; // integer 

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
		return 'catalog_attractions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, city_id, image, country_id', 'required'),
			array('city_id, country_id, del, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>15),
			array('image', 'length', 'max'=>150),
			array('slug', 'length', 'max'=>255),
			array('description, tags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, tags, city_id, image, country_id, slug, del, pos', 'safe', 'on'=>'search'),
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
			'tags' => 'Tags',
			'city_id' => 'City',
			'image' => 'Image',
			'country_id' => 'Country',
			'slug' => 'Slug',
			'del' => 'Del',
			'pos' => 'Pos',
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
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}