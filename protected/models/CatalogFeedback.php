<?php

/**
 * This is the model class for table "catalog_feedback".
   */
class CatalogFeedback extends CCmodel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $pos; // integer 
    protected $del; // integer 
    protected $theme; // string 
    protected $email; // string 
    protected $telefon; // string 

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
		return 'catalog_feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, theme, email, telefon', 'required'),
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('name, telefon', 'length', 'max'=>100),
			array('theme', 'length', 'max'=>150),
			array('email', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, pos, del, theme, email, telefon', 'safe', 'on'=>'search'),
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
			'description' => 'Description',
			'pos' => 'Pos',
			'del' => 'Del',
			'theme' => 'Theme',
			'email' => 'Email',
			'telefon' => 'Telefon',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('theme',$this->theme,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telefon',$this->telefon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}