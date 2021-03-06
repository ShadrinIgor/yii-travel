<?php

/**
 * This is the model class for table "catalog_services".
   */
class CatalogServices extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $price; // integer 
    protected $del; // integer 
    protected $key_word; // string
    protected $description; // string

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
		return 'catalog_services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price', 'required'),
			array('price, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('key_word', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, del, key_word, description', 'safe', 'on'=>'search'),
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
			'price' => 'Price',
            'description' => Yii::t("page", "Описание"),
			'key_word' => 'Key Word',
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
		$criteria->compare('price',$this->price);
		$criteria->compare('del',$this->del);
		$criteria->compare('key_word',$this->key_word,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}