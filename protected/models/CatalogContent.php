<?php

/**
 * This is the model class for table "catalog_content".
   */
class CatalogContent extends CCModel
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
    protected $col; // string
    protected $translate;
    protected $title;

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
			array('name, category_id', 'required'),
			array('country_id, category_id, active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('image', 'length', 'max'=>50),
			array('file', 'length', 'max'=>100),
            array('title, translate, col, slug, name, active, pos, description, date, image, file, del, country_id, category_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, active, pos, description, date, image, file, del, country_id, category_id', 'safe', 'on'=>'search'),
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
			'name' => Yii::t("models", "Название"),
            'title' => 'Title',
			'description' => 'Текст записи',
            'category_id' => Yii::t("models", "Категории"),
            'country_id' => Yii::t("page", "Страна"),
			'date' => Yii::t("models", "Дата"),
			'image' => Yii::t("models", "Картинка"),
			'file' => Yii::t("models", "Файл, приложение для записи"),
            'active' => Yii::t("models", "Активность"),
            'del' => Yii::t("models", "Удаленная запись"),
			'slug' => Yii::t("models", "Название для ссылки"),
            'pos' => Yii::t("models", "Позиция"),
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('key_word',$this->key_word,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}