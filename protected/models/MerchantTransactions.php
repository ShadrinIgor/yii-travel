<?php

/**
 * This is the model class for table "merchant_transactions".
   */
class MerchantTransactions extends CCModel
{
    protected $id; // integer 
    protected $request_id; // integer 
    protected $date; // integer 
    protected $status; // integer 
    protected $response; // string 
    protected $amount; // integer 
    protected $operator; // string
    protected $error; // string

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
		return 'merchant_transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, operator', 'required'),
			array('date, status, amount', 'numerical', 'integerOnly'=>true),
			array('operator', 'length', 'max'=>150),
			array('request_id, date, status, response, amount, operator, error', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, request_id, date, status, response, amount, operator', 'safe', 'on'=>'search'),
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
			'request' => array(self::BELONGS_TO, 'PlantRequest', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_id' => 'Request',
			'date' => 'Date',
			'status' => 'Status',
			'response' => 'Response',
			'amount' => 'Amount',
			'operator' => 'Operator',
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
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('status',$this->status);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('operator',$this->operator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}