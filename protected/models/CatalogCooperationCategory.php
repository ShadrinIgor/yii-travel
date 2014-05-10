<?php

/**
 * This is the model class for table "catalog_cooperation_category".
   */
class CatalogCooperationCategory extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $pos; // integer 
    protected $del; // integer 
    protected $description; // string 
    protected $slug; // string 

/*
* Поля - связи
*/
    protected $catalogCooperations; //  CatalogCooperation


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_cooperation_category';
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
			array('pos, del', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>150),
			array('name, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, pos, del, description, slug', 'safe'),
            array('id, name, pos, del, description, slug', 'safe', 'on'=>'search'),
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
			'catalogCooperations' => array(self::HAS_MANY, 'CatalogCooperation', 'category_id'),
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
			'slug' => 'Slug',
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
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}