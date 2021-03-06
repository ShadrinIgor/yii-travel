<?php

/**
 * This is the model class for table "catalog_info".
   */
class CatalogInfo extends CCModel
{
    protected $id; // integer 
    protected $col; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $pos; // integer 
    protected $metaData; // string 
    protected $del; // integer 
    protected $country_id; // integer 
    protected $city_id; // integer 
    protected $image; // string 
    protected $category_id; // integer 
    protected $list_key; // string 
    protected $slug; // string
    protected $translate;
    protected $tour_category;
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
		return 'catalog_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, category_id', 'required'),
			array('col, pos, del', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>150),
			array('image', 'length', 'max'=>100),
            array('name, country_id, category_id', 'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tour_category, translate, col, name, description, pos, metaData, del, country_id, city_id, image, category_id, list_key, slug', 'safe'),
            array('id, col, name, description, pos, metaData, del, country_id, city_id, image, category_id, list_key, slug', 'safe', 'on'=>'search'),
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
            'tours0' => array(self::MANY_MANY, 'CatalogToursCategory', 'tour_category'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
			'category' => array(self::BELONGS_TO, 'CatalogInfoCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'col' => 'Col',
			'name' => Yii::t("models", "Название"),
			'description' => 'Description',
			'pos' => 'Pos',
			'metaData' => 'Meta Data',
			'del' => 'Del',
			'country_id' => Yii::t("page", "Страна"),
			'city_id' => Yii::t("page", "Город"),
			'image' => 'Image',
			'category_id' => Yii::t("models", "Категория" ),
            //'tour_category' => 'Категория туров',
			'list_key' => 'List Key',
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
		$criteria->compare('col',$this->col);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('metaData',$this->metaData,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('list_key',$this->list_key,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}