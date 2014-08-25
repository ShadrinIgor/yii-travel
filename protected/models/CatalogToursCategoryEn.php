<?php

/**
 * This is the model class for table "catalog_tours_category_en".
   */
class CatalogToursCategoryEn extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $pos; // integer 
    protected $del; // integer 
    protected $owner; // integer 
    protected $slug; // string 
    protected $section_id; // integer 

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
		return 'catalog_tours_category_en';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name', 'required'),
			array('id, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>25),
			array('slug', 'length', 'max'=>150),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, pos, del, owner, slug, section_id', 'safe'),
            array('id, name, description, pos, del, owner, slug, section_id', 'safe', 'on'=>'search'),
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
			'owner0' => array(self::BELONGS_TO, 'CatalogToursCategoryEn', 'owner'),
			'section' => array(self::BELONGS_TO, 'CatalogSectionsEn', 'section_id'),
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
			'pos' => 'Pos',
			'del' => 'Del',
			'owner' => 'Owner',
			'slug' => 'Slug',
			'section_id' => 'Section',
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
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('section_id',$this->section_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}