<?php

/**
 * This is the model class for table "subscribe_status".
   */
class SubscribeTable extends CCModel
{
    protected $id; // integer 
    protected $name; // string
    protected $name_uz; // string //
    protected $del; // integer 
    protected $pos; // integer
    protected $category_id;
    protected $country_id;
    protected $date2;
    protected $sort;
    protected $active;
    protected $image;
    protected $image_uz;
    protected $description;
    protected $table_users_id;
    protected $info_category_id;

    /*
    * Поля - связи
    */
    protected $SubscribeTableUsers; //  SubscribeItems


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscribe_table';
	}

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
            'category' => array(self::BELONGS_TO, 'CatalogToursCategory', 'category_id'),
            'infoCategory' => array(self::BELONGS_TO, 'CatalogInfoCategory', 'info_category_id'),
            'SubscribeTableUsers' => array(self::HAS_MANY, 'SubscribeTableUsers', 'table_users_id'),
        );
    }

    public function fieldType()
    {
        return array_merge( parent::fieldType(), [ "image_uz"=>"image" ] );
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date2', 'required'),
			array('del, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name_uz, image_uz, image, active, info_category_id, table_users_id, description, name, del, pos, category_id, country_id, date2, sort', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Заголовок по мира',
            'name_uz' => "Заголовк по UZ",
            'date2' => 'Дата',
            'image' => 'Баннер - по миру',
            'image_uz' => 'Баннер - по UZ',
            'category_id' => 'Категория тура',
            'country_id' => 'Страна',
            'info_category_id' => 'Информация',
            'description' => 'Вступительный текст',
            'active' => 'Активный',
            'pos' => 'Позиция',
            'del' => 'Del',
            'sort' => 'Sort',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}