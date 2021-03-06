<?php

/**
 * This is the model class for table "subscribe_groups".
   */
class SubscribeGroups extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $pos; // integer 
    protected $del; // integer 

/*
* Поля - связи
*/
    protected $subscribeItems; //  SubscribeItems
    protected $subscribeUsers; //  SubscribeUsers


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscribe_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
            array('id, name, pos, del', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, pos, del', 'safe', 'on'=>'search'),
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
			'subscribeItems' => array(self::HAS_MANY, 'SubscribeItems', 'group_id'),
			'subscribeUsers' => array(self::HAS_MANY, 'SubscribeUsers', 'group_id'),
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
			'pos' => 'Pos',
			'del' => 'Del',
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
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}