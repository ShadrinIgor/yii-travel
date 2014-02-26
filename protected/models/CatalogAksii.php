<?php

/**
 * This is the model class for table "catalog_aksii".
   */
class CatalogAksii extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $ltext; // string 
    protected $country_id; // integer 
    protected $start; // string 
    protected $finish; // string 
    protected $price; // string 
    protected $firm_id; // integer 
    protected $image; // string 

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
		return 'catalog_aksii';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, ltext, start, finish, price, image', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('price', 'length', 'max'=>25),
			array('image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, del, ltext, country_id, start, finish, price, firm_id, image', 'safe', 'on'=>'search'),
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
			'firm' => array(self::BELONGS_TO, 'CatalogFirms', 'firm_id'),
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
			'del' => 'Del',
			'ltext' => 'Ltext',
			'country_id' => 'Country',
			'start' => 'Start',
			'finish' => 'Finish',
			'price' => 'Price',
			'firm_id' => 'Firm',
			'image' => 'Image',
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
		$criteria->compare('ltext',$this->ltext,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('finish',$this->finish,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}