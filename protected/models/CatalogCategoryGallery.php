<?php

/**
 * This is the model class for table "catalog_category_gallery".
   */
class CatalogCategoryGallery extends CCModel
{
    protected $id; // integer 
    protected $cid; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $owner; // integer 

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
		return 'catalog_category_gallery';
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
			array('cid, active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cid, name, active, pos, del, owner', 'safe', 'on'=>'search'),
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
			'owner0' => array(self::BELONGS_TO, 'CatalogCategoryGallery', 'owner'),
			'catalogCategoryGalleries' => array(self::HAS_MANY, 'CatalogCategoryGallery', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cid' => 'Cid',
			'name' => 'Name',
			'active' => 'Active',
			'pos' => 'Pos',
			'del' => 'Del',
			'owner' => 'Owner',
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
		$criteria->compare('cid',$this->cid);
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