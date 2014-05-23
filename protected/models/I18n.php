<?php

/**
 * This is the model class for table "i18n".
   */
class I18n extends CCModel
{
    protected $id; // integer 
    protected $category; // string 
    protected $name; // string 
    protected $pos; // integer 
    protected $del; // integer 

/*
* Поля - связи
*/
    protected $i18nTranslates; //  I18nTranslate


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'i18n';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('category', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category, name, pos, del', 'safe'),
            array('id, category, name, pos, del', 'safe', 'on'=>'search'),
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
			'i18nTranslates' => array(self::HAS_MANY, 'I18nTranslate', 'i18n_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => 'Category',
			'name' => 'Name',
			'pos' => 'Pos',
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}