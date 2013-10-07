<?php

/**
 * This is the model class for table "notifications_messages".
   */
class NotificationsMessages extends CCModel
{
    protected $id; // integer 
    protected $notification_id; // integer 
    protected $type; // string 
    protected $subject; // string 
    protected $mesage; // string 
    protected $template; // string 
    protected $copy_sender; // string 
    protected $del; // integer 
    protected $send_from; // string 

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
		return 'notifications_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notification_id, type, subject, mesage', 'required'),
			array('del', 'numerical', 'integerOnly'=>true),
			array('type, mesage, template, copy_sender, send_from', 'length', 'max'=>25),
			array('subject', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, notification_id, type, subject, mesage, template, copy_sender, del, send_from', 'safe', 'on'=>'search'),
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
			'notification' => array(self::BELONGS_TO, 'Notifications', 'notification_id'),
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
			'type' => 'Type',
			'subject' => 'Subject',
			'mesage' => 'Mesage',
			'template' => 'Template',
			'copy_sender' => 'Copy Sender',
			'del' => 'Del',
			'send_from' => 'Send From',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('mesage',$this->mesage,true);
		$criteria->compare('template',$this->template,true);
		$criteria->compare('copy_sender',$this->copy_sender,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('send_from',$this->send_from,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}