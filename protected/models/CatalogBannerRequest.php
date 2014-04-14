<?php

/**
 * This is the model class for table "catalog_banner_request".
   */
class CatalogBannerRequest extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $date; // integer 
    protected $banner_id; // integer 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 

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
		return 'catalog_banner_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('banner_id', 'required'),
			array('date, active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, date, banner_id, active, pos, del', 'safe'),
            array('id, name, date, banner_id, active, pos, del', 'safe', 'on'=>'search'),
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
			'banner' => array(self::BELONGS_TO, 'CatalogFirmsBanners', 'banner_id'),
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
			'date' => 'Date',
			'banner_id' => 'Banner',
			'active' => 'Active',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('banner_id',$this->banner_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function onBannerRequest($event)
    {
        if($this->hasEventHandler('onBannerRequest'))
            $this->raiseEvent('onBannerRequest', $event);
    }
}