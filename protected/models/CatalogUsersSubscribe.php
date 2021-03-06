<?php

/**
 * This is the model class for table "catalog_users_confirm".
   */
class CatalogUsersSubscribe extends CCModel
{
    protected $id; // integer 
    protected $email; // integer
    protected $name; // string
    protected $del; // integer
    protected $pos; // string

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
		return 'catalog_users_subscribe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, email', 'safe'),
            array('id, user_id, confirm_key, date, type, del', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'name',
			'email' => 'email',
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


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}