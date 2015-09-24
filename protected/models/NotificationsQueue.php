<?php

/**
 * This is the model class for table "notifications".
   */
class NotificationsQueue extends CCModel
{
    protected $id; // integer 
    protected $date; // integer
    protected $date2; // integer
    protected $del; // integer 
    protected $item_id; // integer
    protected $catalog; // string
    protected $step; // string

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
		return 'notifications_queue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, item_id, catalog', 'required'),
			array('step, date, del, item_id', 'numerical', 'integerOnly'=>true),
			array('catalog', 'length', 'max'=>150),
            array('step, date, date2, del, item_id, catalog', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
            'date2' => 'Date',
			'item_id' => 'Item',
			'catalog' => 'Catalog',
            'step' => 'Step',
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
		$criteria->compare('date',$this->date);
        $criteria->compare('date2',$this->date);
		$criteria->compare('del',$this->del);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('catalog',$this->catalog,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}