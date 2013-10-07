<?php

/**
 * This is the model class for table "notifications".
   */
class Notifications extends CCModel
{
    protected $id; // integer 
    protected $type_id; // integer 
    protected $user_id; // integer 
    protected $date; // integer 
    protected $del; // integer 
    protected $action_id; // integer 
    protected $item_id; // integer 
    protected $catalog; // string 
    protected $is_new; // integer 
    protected $message; // string 
    protected $subject; // string 

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
		return 'notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, user_id', 'required'),
			array('date, del, item_id, is_new', 'numerical', 'integerOnly'=>true),
			array('catalog', 'length', 'max'=>50),
			array('subject', 'length', 'max'=>150),
			array('message, is_new', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, user_id, date, del, action_id, item_id, catalog, is_new, message, subject', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'NotificationsType', 'type_id'),
			'action' => array(self::BELONGS_TO, 'NotificationsActions', 'action_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type_id' => 'Type',
			'user_id' => 'User',
			'date' => 'Date',
			'del' => 'Del',
			'action_id' => 'Action',
			'item_id' => 'Item',
			'catalog' => 'Catalog',
			'is_new' => 'Is New',
			'message' => 'Message',
			'subject' => 'Subject',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('del',$this->del);
		$criteria->compare('action_id',$this->action_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('subject',$this->subject,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}