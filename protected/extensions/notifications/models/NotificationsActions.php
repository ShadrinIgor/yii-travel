<?php

/**
 * This is the model class for table "notifications_actions".
   */
class NotificationsActions extends CCModel
{
    protected $id; // integer 
    protected $type_id; // integer 
    protected $key_word; // string 
    protected $subject; // string 
    protected $mesage; // string 
    protected $template; // string 
    protected $copy_sender; // string 
    protected $del; // integer 
    protected $send_from; // string 
    protected $to_user; // string 

/*
* Поля - связи
*/
    protected $notifications; //  Notifications


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notifications_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, key_word, subject, mesage', 'required'),
			array('del', 'numerical', 'integerOnly'=>true),
			array('key_word, template, copy_sender, send_from', 'length', 'max'=>25),
			array('subject', 'length', 'max'=>50),
			array('to_user', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, key_word, subject, mesage, template, copy_sender, del, send_from, to_user', 'safe', 'on'=>'search'),
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
			'notifications' => array(self::HAS_MANY, 'Notifications', 'action_id'),
			'type' => array(self::BELONGS_TO, 'NotificationsType', 'type_id'),
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
			'key_word' => 'Key Word',
			'subject' => 'Subject',
			'mesage' => 'Mesage',
			'template' => 'Template',
			'copy_sender' => 'Copy Sender',
			'del' => 'Del',
			'send_from' => 'Send From',
			'to_user' => 'To User',
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
		$criteria->compare('key_word',$this->key_word,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('mesage',$this->mesage,true);
		$criteria->compare('template',$this->template,true);
		$criteria->compare('copy_sender',$this->copy_sender,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('send_from',$this->send_from,true);
		$criteria->compare('to_user',$this->to_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}