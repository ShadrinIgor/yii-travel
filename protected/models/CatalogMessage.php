<?php

/**
 * This is the model class for table "catalog_message".
   */
class CatalogMessage extends CCmodel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $from_name; // string 
    protected $from_email; // string 
    protected $from_telefon; // string 
    protected $to; // string 
    protected $new; // integer 
    protected $del; // integer 
    protected $timeadd; // string 

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
		return 'catalog_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, from_name, from_email, from_telefon, to, timeadd', 'required'),
			array('active, pos, new, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('from_name, from_email, from_telefon', 'length', 'max'=>50),
			array('to', 'length', 'max'=>15),
			array('timeadd', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, from_name, from_email, from_telefon, to, new, del, timeadd', 'safe', 'on'=>'search'),
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
			'from_name' => 'From Name',
			'from_email' => 'From Email',
			'from_telefon' => 'From Telefon',
			'to' => 'To',
			'new' => 'New',
			'del' => 'Del',
			'timeadd' => 'Timeadd',
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
		$criteria->compare('from_name',$this->from_name,true);
		$criteria->compare('from_email',$this->from_email,true);
		$criteria->compare('from_telefon',$this->from_telefon,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('new',$this->new);
		$criteria->compare('del',$this->del);
		$criteria->compare('timeadd',$this->timeadd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}