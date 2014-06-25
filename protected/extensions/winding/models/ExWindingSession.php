<?php

/**
 * This is the model class for table "ex_winding_session".
   */
class ExWindingSession extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $winding_id; // integer 
    protected $useragents_id; // integer 
    protected $date; // integer 
    protected $date_next; // integer 
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
		return 'ex_winding_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, winding_id, useragents_id, date, date_next', 'required'),
			array('date, date_next, del, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, winding_id, useragents_id, date, date_next, del, pos', 'safe'),
            array('id, name, winding_id, useragents_id, date, date_next, del, pos', 'safe', 'on'=>'search'),
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
			'winding' => array(self::BELONGS_TO, 'ExWinding', 'winding_id'),
			'useragents' => array(self::BELONGS_TO, 'ExWindingUseragents', 'useragents_id'),
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
			'winding_id' => 'Winding',
			'useragents_id' => 'Useragents',
			'date' => 'Date',
			'date_next' => 'Date Next',
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
		$criteria->compare('winding_id',$this->winding_id);
		$criteria->compare('useragents_id',$this->useragents_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('date_next',$this->date_next);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}