<?php

/**
 * This is the model class for table "subscribe_send".
   */
class SubscribeSend extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $item_id; // integer 
    protected $user_id; // integer 
    protected $pos; // integer 
    protected $del; // integer
    protected $email;
    protected $is_reg;
    protected $is_open;

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
		return 'subscribe_send';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, email', 'required'),
			array('is_open, is_reg, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('is_open, is_reg, email, name, item_id, user_id, pos, del', 'safe'),
            array('id, name, item_id, user_id, pos, del', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
			'item' => array(self::BELONGS_TO, 'SubscribeItems', 'item_id'),
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
			'item_id' => 'Item',
			'user_id' => 'User',
			'pos' => 'Pos',
			'del' => 'Del',
            'email'=>'email',
            'is_reg'=>'is_reg',
            'is_open'=>'is_open'
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
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}