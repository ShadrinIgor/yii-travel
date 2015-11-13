<?php

/**
 * This is the model class for table "cat_log_firms".
   */
class ExBannerLog extends CCModel
{
    protected $id; // integer 
    protected $banner_id; // integer 
    protected $action_show; // integer 
    protected $action_click; // integer 
    protected $name; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $date; // integer 

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
		return 'ex_banner_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('banner_id, date', 'required'),
			array('banner_id, action_show, action_click, name, del, pos, date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('id, banner_id, action_show, action_click, name, del, pos, date', 'safe'),
			array('id, banner_id, action_show, action_click, name, del, pos, date', 'safe', 'on'=>'search'),
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
			'banner_id' => array(self::BELONGS_TO, 'ExBanner', 'banner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'banner_id' => 'Firm',
			'action_show' => 'Action Show',
			'action_click' => 'Action Contact',
			'name' => 'Name',
			'del' => 'Del',
			'pos' => 'Pos',
			'date' => 'Date From',
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
		$criteria->compare('banner_id',$this->banner_id);
		$criteria->compare('action_show',$this->action_show);
		$criteria->compare('action_click',$this->action_click);
		$criteria->compare('name',$this->name);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}