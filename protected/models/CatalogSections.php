<?php

/**
 * This is the model class for table "catalog_sections".
   */
class CatalogSections extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $del; // integer 
    protected $pos; // integer 
    protected $tours; // integer 
    protected $info; // integer 
    protected $images; // string 
    protected $words; // string 
    protected $country_id; // integer 
    protected $baner_l; // string 
    protected $curorts; // integer 
    protected $description; // string 
    protected $slug; // string 

/*
* Поля - связи
*/
    protected $catalogInfoCategories; //  CatalogInfoCategory
    protected $catalogKurortsCategories; //  CatalogKurortsCategory
    protected $catalogToursCategories; //  CatalogToursCategory


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_sections';
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
			array('del, pos', 'numerical', 'integerOnly'=>true),
			array('name, images', 'length', 'max'=>25),
			array('baner_l', 'length', 'max'=>255),
			array('slug', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('slug, name, del, pos, tours, info, images, words, country_id, baner_l, curorts, description', 'safe'),
			array('id, name, del, pos, tours, info, images, words, country_id, baner_l, curorts, description, slug', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'tours0' => array(self::MANY_MANY, 'CatalogToursCategory', 'tours'),
			'info0' => array(self::MANY_MANY, 'CatalogInfoCategory', 'info'),
			'curorts0' => array(self::MANY_MANY, 'CatalogKurortsCategory', 'curorts'),
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
			'del' => 'Del',
			'pos' => 'Pos',
			'tours' => 'Tours',
			'info' => 'Info',
			'images' => 'Images',
			'words' => 'Words',
			'country_id' => 'Country',
			'baner_l' => 'Baner L',
			'curorts' => 'Curorts',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('tours',$this->tours);
		$criteria->compare('info',$this->info);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('words',$this->words,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('baner_l',$this->baner_l,true);
		$criteria->compare('curorts',$this->curorts);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}