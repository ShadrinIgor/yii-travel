<?php

/**
 * This is the model class for table "notifications_items".
   */
class NotificationsItems extends CCModel
{
    protected $id; // integer 
    protected $notification_id; // integer 
    protected $message_id; // integer 
    protected $user_id; // integer 
    protected $date; // integer 
    protected $del; // integer 

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
		return 'notifications_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notification_id, message_id, user_id', 'required'),
			array('date, del', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, notification_id, message_id, user_id, date, del', 'safe', 'on'=>'search'),
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
			'notification' => array(self::BELONGS_TO, 'Notifications', 'notification_id'),
			'message' => array(self::BELONGS_TO, 'NotificationsMessages', 'message_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'notification_id' => 'Notification',
			'message_id' => 'Message',
			'user_id' => 'User',
			'date' => 'Date',
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
		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('message_id',$this->message_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}