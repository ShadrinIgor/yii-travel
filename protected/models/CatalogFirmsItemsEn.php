<?php

/**
 * This is the model class for table "catalog_firms_items_en".
   */
class CatalogFirmsItemsEn extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $date; // integer 
    protected $firm_id; // integer 
    protected $user_id; // integer 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $slug; // string 
    protected $col; // integer 

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
		return 'catalog_firms_items_en';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, date, user_id, slug', 'required'),
			array('id, date, firm_id, user_id, active, pos, del, col', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('slug', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, date, firm_id, user_id, active, pos, del, slug, col', 'safe'),
            array('id, name, description, date, firm_id, user_id, active, pos, del, slug, col', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'description' => 'Description',
			'date' => 'Date',
			'firm_id' => 'Firm',
			'user_id' => 'User',
			'active' => 'Active',
			'pos' => 'Pos',
			'del' => 'Del',
			'slug' => 'Slug',
			'col' => 'Col',
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('col',$this->col);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}