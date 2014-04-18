<?php

/**
 * This is the model class for table "cat_log".
   */
class CatLog extends CCModel
{
    protected $id; // integer 
    protected $date; // string 
    protected $catalog; // string 
    protected $item_id; // integer 
    protected $action; // string 
    protected $user_id; // integer
    protected $date2;
    protected $del;

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
		return 'cat_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, date2, catalog, item_id, action', 'required'),
			array('del, date, item_id', 'numerical', 'integerOnly'=>true),
			array('catalog', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('del, date2, date, catalog, item_id, action, user_id', 'safe'),
            array('id, date, catalog, item_id, action, user_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'catalog' => 'Catalog',
			'item_id' => 'Item',
			'action' => 'Action',
			'user_id' => 'User',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}