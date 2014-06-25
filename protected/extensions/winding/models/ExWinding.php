<?php

/**
 * This is the model class for table "ex_winding".
   */
class ExWinding extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $url; // string 
    protected $del; // integer 
    protected $pos; // integer 
    protected $active; // integer 
    protected $pageCountMax; // integer 
    protected $listStartPage; // string 
    protected $listReferalPage; // string 
    protected $directСalls; // integer 

/*
* Поля - связи
*/
    protected $exWindingSessions; //  ExWindingSession
    protected $exWindingStats; //  ExWindingStat


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ex_winding';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, listStartPage, listReferalPage', 'required'),
			array('del, pos, active, pageCountMax, directСalls', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, url, del, pos, active, pageCountMax, listStartPage, listReferalPage, directСalls', 'safe'),
            array('id, name, url, del, pos, active, pageCountMax, listStartPage, listReferalPage, directСalls', 'safe', 'on'=>'search'),
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
			'exWindingSessions' => array(self::HAS_MANY, 'ExWindingSession', 'winding_id'),
			'exWindingStats' => array(self::HAS_MANY, 'ExWindingStat', 'winding_id'),
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
			'url' => 'Url',
			'del' => 'Del',
			'pos' => 'Pos',
			'active' => 'Active',
			'pageCountMax' => 'Page Count Max',
			'listStartPage' => 'List Start Page',
			'listReferalPage' => 'List Referal Page',
			'directСalls' => 'DirectСalls',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('active',$this->active);
		$criteria->compare('pageCountMax',$this->pageCountMax);
		$criteria->compare('listStartPage',$this->listStartPage,true);
		$criteria->compare('listReferalPage',$this->listReferalPage,true);
		$criteria->compare('directСalls',$this->directСalls);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}