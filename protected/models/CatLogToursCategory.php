<?php

/**
 * This is the model class for table "cat_log_tours_category".
   */
class CatLogToursCategory extends CCModel
{
    protected $id; // integer 
    protected $cid_id; // integer 
    protected $action_cid_show; // integer 
    protected $action_tor_show; // integer 
    protected $name; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $date_from; // integer 
    protected $date_to; // integer 

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
		return 'cat_log_tours_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid_id, date_from', 'required'),
			array('cid_id, action_cid_show, action_tor_show, name, del, pos, date_from, date_to', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cid_id, action_cid_show, action_tor_show, name, del, pos, date_from, date_to', 'safe'),
            array('id, cid_id, action_cid_show, action_tor_show, name, del, pos, date_from, date_to', 'safe', 'on'=>'search'),
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
			'cid_id' => 'Cid',
			'action_cid_show' => 'Action Cid Show',
			'action_tor_show' => 'Action Tor Show',
			'name' => 'Name',
			'del' => 'Del',
			'pos' => 'Pos',
			'date_from' => 'Date From',
			'date_to' => 'Date To',
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
		$criteria->compare('cid_id',$this->cid_id);
		$criteria->compare('action_cid_show',$this->action_cid_show);
		$criteria->compare('action_tor_show',$this->action_tor_show);
		$criteria->compare('name',$this->name);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('date_from',$this->date_from);
		$criteria->compare('date_to',$this->date_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}