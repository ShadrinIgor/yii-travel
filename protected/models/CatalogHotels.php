<?php

/**
 * This is the model class for table "catalog_hotels".
   */
class CatalogHotels extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $pos; // integer 
    protected $country_id; // integer 
    protected $city_id; // integer 
    protected $address; // string 
    protected $del; // integer 
    protected $image; // string 
    protected $level; // string 
    protected $email; // string 
    protected $www; // string 
    protected $fax; // string 
    protected $tel; // string 
    protected $col; // integer 
    protected $slug; // string 
    protected $user_id; // integer 
    protected $active; // integer
    protected $translate;

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
		return 'catalog_hotels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, country_id, city_id, email, tel', 'required'),
			array('pos, del, level, col, country_id, city_id, user_id, active', 'numerical', 'integerOnly'=>true),
			array('name, image', 'length', 'max'=>100),
			array('level', 'length', 'max'=>25),
			array('email, www, fax, tel, slug', 'length', 'max'=>150),
            array('country_id, city_id, level', 'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('translate, user_id, active, name, description, pos, country_id, city_id, address, del, image, level, email, www, fax, tel, col, slug', 'safe'),
			array('id, name, description, pos, country_id, city_id, address, del, image, level, email, www, fax, tel, col, slug, user_id, active', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(),
                        array( "level"=>"integer" )
                    );
    }

    public function attributePlaceholder()
    {
        return array_merge(
            parent::attributePlaceholder(),
            array( "level"=>"от 1 до 5" )
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
			'country_id' => Yii::t("page", "Страна"),
			'city_id' => Yii::t("page", "Город"),
			'address' => Yii::t("models", "адрес" ),
			'level' => Yii::t("models", "Кол. звезд" ),
			'email' => 'Email',
			'www' => Yii::t("models", "Сайт" ),
			'fax' => Yii::t("models", "Факс" ),
			'tel' => Yii::t("models", "Телефон"),
            'description' => Yii::t("page", "Описание"),
			'col' => 'Col',
			'slug' => 'Slug',
			'user_id' => 'User',
			'active' => 'Is Active',
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('www',$this->www,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('col',$this->col);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}