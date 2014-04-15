<?php

/**
 * This is the model class for table "subscribe_items".
   */
class SubscribeItems extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $group_id; // integer 
    protected $subject; // string 
    protected $description; // string 
    protected $pos; // integer 
    protected $del; // integer 
    protected $status_id; // integer 
    protected $date; // integer 
    protected $date_start; // integer 
    protected $users; // integer 
    protected $users_list; // string
    protected $count_send;

/*
* Поля - связи
*/
    protected $subscribeSends; //  SubscribeSend


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscribe_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, subject, status_id, date, users', 'required'),
			array('count_send, pos, del, date, date_start, users', 'numerical', 'integerOnly'=>true),
			array('name, subject', 'length', 'max'=>150),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('count_send, date, date_start, name, group_id, subject, description, pos, del, status_id, date, date_start, users, users_list', 'safe'),
            array('id, name, group_id, subject, description, pos, del, status_id, date, date_start, users, users_list', 'safe', 'on'=>'search'),
		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "date_start"=>"date" ) );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'group' => array(self::BELONGS_TO, 'SubscribeGroups', 'group_id'),
			'status' => array(self::BELONGS_TO, 'SubscribeStatus', 'status_id'),
			'subscribeSends' => array(self::HAS_MANY, 'SubscribeSend', 'item_id'),
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
			'group_id' => 'Group',
			'subject' => 'Subject',
			'description' => 'Description',
			'pos' => 'Pos',
			'del' => 'Del',
			'status_id' => 'Status',
			'date' => 'Date',
			'date_start' => 'Date Start',
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
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('date_start',$this->date_start);
		$criteria->compare('users',$this->users);
		$criteria->compare('users_list',$this->users_list,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}