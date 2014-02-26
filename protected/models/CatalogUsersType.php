<?php

/**
 * This is the model class for table "catalog_users_type".
   */
class CatalogUsersType extends CCModel
{
    protected $id; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $name; // string 
    protected $key_word; // string 

/*
* Поля - связи
*/
    protected $catalogUsers; //  CatalogUsers


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_users_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, key_word', 'required'),
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('key_word', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pos, del, name, key_word', 'safe', 'on'=>'search'),
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
			'catalogUsers' => array(self::HAS_MANY, 'CatalogUsers', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pos' => 'Pos',
			'del' => 'Del',
			'name' => 'Name',
			'key_word' => 'Key Word',
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
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('key_word',$this->key_word,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}