<?php

/**
 * This is the model class for table "catalog_training".
   */
class CatalogTraining extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $step; // integer 
    protected $user_type; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $method; // string
    protected $group;

/*
* Поля - связи
*/
    protected $catalogTrainingSessions; //  CatalogTrainingSession


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_training';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, method', 'required'),
			array('step, user_type, del, pos', 'numerical', 'integerOnly'=>true),
			array('name, method', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(' name, step, user_type, del, pos, method', 'safe' ),
            array('id, name, step, user_type, del, pos, method', 'safe', 'on'=>'search'),
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
			'userType' => array(self::BELONGS_TO, 'CatalogUsersType', 'user_type'),
			'catalogTrainingSessions' => array(self::HAS_MANY, 'CatalogTrainingSession', 'training_id'),
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
			'step' => 'Step',
			'user_type' => 'User Type',
			'del' => 'Del',
			'pos' => 'Pos',
			'method' => 'Method',
            'group' => 'group'
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
		$criteria->compare('step',$this->step);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('method',$this->method,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}