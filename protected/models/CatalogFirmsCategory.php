<?php

/**
 * This is the model class for table "catalog_firm_category".
   */
class CatalogFirmsCategory extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $owner; // integer
    protected $slug; // integer
    protected $description;

/*
* Поля - связи
*/
    protected $catalogFirms; //  CatalogFirms


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_firms_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('slug, description, id, name, active, pos, del, owner', 'safe'),
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
			'owner0' => array(self::BELONGS_TO, 'CatalogFirmsCategory', 'owner'),
			'catalogFirmCategories' => array(self::HAS_MANY, 'CatalogFirmsCategory', 'owner'),
			'catalogFirms' => array(self::HAS_MANY, 'CatalogFirms', 'category_id'),
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
			'active' => 'Active',
			'pos' => 'Pos',
			'del' => 'Del',
			'owner' => 'Owner',
            'description' => 'description',
            'slug' => 'slug'
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
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('owner',$this->owner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}