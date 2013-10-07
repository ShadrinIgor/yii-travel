<?php

/**
 * This is the model class for table "catalog_users_confirm".
   */
class CatalogUsersConfirm extends CCModel
{
    protected $id; // integer 
    protected $user_id; // integer 
    protected $confirm_key; // string 
    protected $date; // integer
    protected $type; // enum ( registration, lostpassword )


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
		return 'catalog_users_confirm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, confirm_key, date', 'required'),
			array('date', 'numerical', 'integerOnly'=>true),
			array('confirm_key', 'length', 'max'=>25),
            array('user_id', 'checked_exists_user'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, confirm_key, date, type', 'safe', 'on'=>'search'),
		);
	}

    public function checked_exists_user($attribute,$params)
    {
        if( !$this->hasErrors() && !empty( $this->user_id ) && $this->user_id->id>0  )
        {
            $exists = CatalogUsers::fetch( $this->user_id->id );
            if( sizeof( $exists )==0 )$this->addErrors( array(  "0"=>"Указан не существующий ID пользоватлея" ) );
        }
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'confirm_key' => 'Confirm Key',
			'date' => 'Date',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('confirm_key',$this->confirm_key,true);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}