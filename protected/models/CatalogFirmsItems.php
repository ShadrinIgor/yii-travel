<?php

/**
 * This is the model class for table "catalog_firms_items".
   */
class CatalogFirmsItems extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $date; // integer
    protected $date2; // integer
    protected $firm_id; // integer 
    protected $user_id; // integer 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer
    protected $slug;
    protected $translate;
    protected $sale;
    protected $date_add;
    protected $date_edit;

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
		return 'catalog_firms_items';
	}

    public function attributePlaceholder()
    {
        return array_merge( parent::attributePlaceholder(),
                array(
                    "name" => "Название акции",
                    "date" => "Дата начала акции",
                    "date2" => "Дата окончания акции",
                    "sale"  => "Процент скидки"
                ) );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, user_id', 'required'),
			array('date, active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
            array('date_edit, date_add, sale, date2, slug, name, description, date, firm_id, user_id, active, pos, del', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, date, firm_id, user_id, active, pos, del', 'safe', 'on'=>'search'),
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
			'firm' => array(self::BELONGS_TO, 'CatalogFirms', 'firm_id'),
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "date2"=>"date" ) );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'date' => 'Date',
            'date2' => 'Date',
			'sale' => 'sale',
            'firm_id' => 'Firm',
			'user_id' => 'User',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function onAddFirmsItems( $event, $params = array()  )
    {
        if($this->hasEventHandler('onAddFirmsItems'))
            $this->raiseEvent('onAddFirmsItems', array( "event"=>$event, "params"=>$params ) );
    }
}