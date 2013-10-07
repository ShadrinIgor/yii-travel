<?php

/**
 * This is the model class for table "order_request".
   */
class OrderRequest extends CCModel
{
    protected $id; // integer 
    protected $date; // integer 
    protected $user_id; // integer 
    protected $catalog; // integer 
    protected $item_id; // integer 
    protected $comment; // string 
    protected $status_id; // integer 
    protected $del; // integer 
    protected $amount; // integer 
    protected $finish_date; // integer 
    protected $type_id; // integer 

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
		return 'order_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, user_id, type_id', 'required'),
			array('date, item_id, del, amount, finish_date', 'numerical', 'integerOnly'=>true),
			array('date, user_id, catalog, item_id, comment, status_id, del, amount, finish_date, type_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, user_id, catalog, item_id, comment, status_id, del, amount, finish_date, type_id', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'OrderRequestType', 'type_id'),
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
			'status' => array(self::BELONGS_TO, 'OrderRequestStatus', 'status_id'),
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
			'user_id' => 'User',
			'catalog' => 'Catalog',
			'item_id' => 'Item',
			'comment' => 'Comment',
			'status_id' => 'Status',
			'del' => 'Del',
			'amount' => 'Amount',
			'finish_date' => 'Finish Date',
			'type_id' => 'Type',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('catalog',$this->catalog);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('finish_date',$this->finish_date);
		$criteria->compare('type_id',$this->type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}