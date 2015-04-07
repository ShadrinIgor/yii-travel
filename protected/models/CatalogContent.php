<?php

/**
 * This is the model class for table "catalog_content".
   */
class CatalogContent extends CCModel
{
    protected $id; // integer 
    protected $date; // integer 
    protected $del; // integer 
    protected $image; // string 
    protected $category_id; // integer 
    protected $slug; // string 
    protected $name; // string 
    protected $description; // string
    protected $description2; // string
    protected $description3; // string
    protected $description_author;
    protected $file; // string
    protected $title;
    protected $meta_keyword;
    protected $expert_text;
    protected $expert_name;

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
		return 'catalog_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, name, title, description', 'required'),
			array('date, del', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			array('slug', 'length', 'max'=>255),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('expert_name, expert_text, meta_keyword, description_author, title, file, date, del, image, category_id, slug, name, description, description2, description3', 'safe'),
            array('id, date, del, image, category_id, slug, name, description', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'CatalogContentCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'name' => 'Название',
            'title' => 'Title',
            'slug' => 'Slug',
			'date' => 'Дата',
			'image' => 'Картинка',
            'file' => 'Файл',
			'category_id' => 'Категория',
			'description' => 'Описание',
            'description2' => 'Описание2',
            'description3' => 'Описание3',
            'description_author' => 'О авторе',
            'meta_keyword' => 'meta_keyword',
            'expert_name' => 'expert_name',
            'expert_text' => 'expert_text',

		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "expert_name"=>"textarea", "expert_text"=>"textarea", "meta_keyword"=>"textarea", "description2"=>"visual_textarea", "description_author"=>"visual_textarea", "description3"=>"visual_textarea", ) );
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
		$criteria->compare('date',$this->date);
		$criteria->compare('del',$this->del);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}