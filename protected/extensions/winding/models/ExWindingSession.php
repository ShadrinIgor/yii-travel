<?php

/**
 * This is the model class for table "ex_winding_session".
   */
class ExWindingSession extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $winding_id; // integer 
    protected $useragents_id; // integer
    protected $need_count;
    protected $referal;
    protected $del; // integer
    protected $pos; // integer
    protected $proxi;
    protected $visit_id;

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
		return 'ex_winding_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('winding_id, useragents_id', 'required'),
			array('need_count, del, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('visit_id, proxi, referal, need_count, name, winding_id, useragents_id, del, pos', 'safe'),
            array('id, name, winding_id, useragents_id, del, pos', 'safe', 'on'=>'search'),
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
			'winding' => array(self::BELONGS_TO, 'ExWinding', 'winding_id'),
			'useragents' => array(self::BELONGS_TO, 'ExWindingUseragents', 'useragents_id'),
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
			'winding_id' => 'Winding',
			'useragents_id' => 'Useragents',
			'del' => 'Del',
			'pos' => 'Pos',
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
		$criteria->compare('winding_id',$this->winding_id);
		$criteria->compare('useragents_id',$this->useragents_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}