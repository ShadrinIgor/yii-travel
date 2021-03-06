<?php

/**
 * This is the model class for table "catalog_info_category".
   */
class CatalogInfoCategory extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $pos; // integer 
    protected $del; // integer 
    protected $owner; // integer 
    protected $slug; // string
    protected $description;
    protected $translate;

/*
* Поля - связи
*/
    protected $catalogInfos; //  CatalogInfo


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_info_category';
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
			array('name', 'length', 'max'=>100),
			array('slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('translate, description, name, pos, del, owner, slug', 'safe'),
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
			'catalogInfos' => array(self::HAS_MANY, 'CatalogInfo', 'category_id'),
			'owner0' => array(self::BELONGS_TO, 'CatalogInfoCategory', 'owner'),
			'catalogInfoCategories' => array(self::HAS_MANY, 'CatalogInfoCategory', 'owner'),
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
			'pos' => 'Pos',
			'del' => 'Del',
			'owner' => 'Owner',
			'slug' => 'Slug',
            'description' => 'description'
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
		$criteria->compare('owner',$this->owner);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}