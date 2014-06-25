<?php

/**
 * This is the model class for table "ex_winding_timetable".
   */
class ExWindingTimetable extends CCModel
{
    protected $id; // integer 
    protected $name; // integer 
    protected $count_item; // integer 
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
		return 'ex_winding_timetable';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, count_item', 'required'),
			array('name, count_item, del, pos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, count_item, del, pos', 'safe'),
            array('id, name, count_item, del, pos', 'safe', 'on'=>'search'),
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
			'count_item' => 'Count Item',
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
		$criteria->compare('name',$this->name);
		$criteria->compare('count_item',$this->count_item);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}