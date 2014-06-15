<?php

/**
 * This is the model class for table "catalog_contJat_zh".
   */
class CatalogContentZh extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $description; // string 
    protected $date; // string 
    protected $image; // string 
    protected $file; // string 
    protected $del; // integer 
    protected $country_id; // integer 
    protected $category_id; // integer 
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
		return 'catalog_content_zh';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, category_id', 'required'),
			array('id, active, pos, del, col', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('image', 'length', 'max'=>50),
			array('file', 'length', 'max'=>100),
			array('slug', 'length', 'max'=>150),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, active, pos, description, date, image, file, del, country_id, category_id, slug, col', 'safe'),
            array('id, name, active, pos, description, date, image, file, del, country_id, category_id, slug, col', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically gJaerated below.
		return array(
			'category' => array(self::BELONGS_TO, 'CatalogContentCategory', 'category_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
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
			'description' => 'Description',
			'date' => 'Date',
			'image' => 'Image',
			'file' => 'File',
			'del' => 'Del',
			'country_id' => 'Country',
			'category_id' => 'Category',
			'slug' => 'Slug',
			'col' => 'Col',
		);
	}

	/**
	 * Retrieves a list of models based on the currJat search/filter conditions.
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('col',$this->col);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}