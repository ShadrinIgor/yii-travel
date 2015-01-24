<?php

/**
 * This is the model class for table "catalog_wheters".
   */
class CatalogWheters extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $del; // integer 
    protected $pos; // integer 
    protected $title; // string 
    protected $value1; // string 
    protected $value2; // string 
    protected $city_id; // integer
    protected $image;

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
		return 'catalog_wheters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, title, city_id, image', 'required'),
			array('del, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>15),
			array('title', 'length', 'max'=>50),
			array('value1, value2', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('image, id, name, del, pos, title, value1, value2, city_id', 'safe'),
            array('id, name, del, pos, title, value1, value2, city_id', 'safe', 'on'=>'search'),
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
			'del' => 'Del',
			'pos' => 'Pos',
			'title' => 'Title',
			'value1' => 'Value1',
			'value2' => 'Value2',
			'city_id' => 'City',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value1',$this->value1,true);
		$criteria->compare('value2',$this->value2,true);
		$criteria->compare('city_id',$this->city_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}