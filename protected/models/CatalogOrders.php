<?php

/**
 * This is the model class for table "catalog_orders".
   */
class CatalogOrders extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $telefon; // string 
    protected $email; // string 
    protected $tour; // string 
    protected $tour_agent; // string 
    protected $date_order; // string 
    protected $time_order; // string 

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
		return 'catalog_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, telefon, email, tour, tour_agent, date_order, time_order', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('telefon', 'length', 'max'=>100),
			array('email', 'length', 'max'=>50),
			array('tour, tour_agent', 'length', 'max'=>25),
			array('time_order', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, del, telefon, email, tour, tour_agent, date_order, time_order', 'safe', 'on'=>'search'),
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
			'active' => 'Active',
			'pos' => 'Pos',
			'del' => 'Del',
			'telefon' => 'Telefon',
			'email' => 'Email',
			'tour' => 'Tour',
			'tour_agent' => 'Tour Agent',
			'date_order' => 'Date Order',
			'time_order' => 'Time Order',
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
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tour',$this->tour,true);
		$criteria->compare('tour_agent',$this->tour_agent,true);
		$criteria->compare('date_order',$this->date_order,true);
		$criteria->compare('time_order',$this->time_order,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}