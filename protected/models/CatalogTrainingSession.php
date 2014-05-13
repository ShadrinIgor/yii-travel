<?php

/**
 * This is the model class for table "catalog_training_session".
   */
class CatalogTrainingSession extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $user_id; // integer 
    protected $training_id; // integer 
    protected $date; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $close; // integer 

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
		return 'catalog_training_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, training_id, date', 'required'),
			array('user_id, training_id, date, pos, del, close', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, user_id, training_id, date, pos, del, close', 'safe' ),
            array('id, name, user_id, training_id, date, pos, del, close', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'training_id' => 'Training',
			'date' => 'Date',
			'pos' => 'Pos',
			'del' => 'Del',
			'close' => 'Close',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('training_id',$this->training_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('close',$this->close);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}