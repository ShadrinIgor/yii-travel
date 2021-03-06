<?php

/**
 * This is the model class for table "catalog_firms_coments".
   */
class CatalogFirmsComments extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $fio; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $date; // integer 
    protected $del; // integer 
    protected $firm_id; // integer 
    protected $user_id; // integer 
    protected $description; // string
    protected $is_new; // string

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
		return 'catalog_firms_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, fio, firm_id, user_id, description', 'required'),
			array('active, pos, date, del', 'numerical', 'integerOnly'=>true),
			array('name, fio', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, fio, active, pos, date, del, firm_id, user_id, description', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
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
			'fio' => 'Fio',
			'active' => 'Active',
			'pos' => 'Pos',
			'date' => 'Date',
			'del' => 'Del',
			'firm_id' => 'Firm',
			'user_id' => 'User',
			'description' => 'Description',
            'is_new' => 'is new',
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
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('date',$this->date);
		$criteria->compare('del',$this->del);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}