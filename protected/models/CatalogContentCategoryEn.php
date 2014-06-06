<?php

/**
 * This is the model class for table "catalog_content_category_en".
   */
class CatalogContentCategoryEn extends CCModel
{
    protected $id; // integer 
    protected $del; // integer 
    protected $image; // string 
    protected $pos; // integer 
    protected $name; // string 
    protected $slug; // string 

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
		return 'catalog_content_category_en';
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
			array('id, del, pos', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			array('name, slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, del, image, pos, name, slug', 'safe'),
            array('id, del, image, pos, name, slug', 'safe', 'on'=>'search'),
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
			'del' => 'Del',
			'image' => 'Image',
			'pos' => 'Pos',
			'name' => 'Name',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}