<?php

/**
 * This is the model class for table "catalog_work_en".
   */
class CatalogWorkJa extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $image; // string 
    protected $description; // string 
    protected $contacts; // string 
    protected $price; // integer 
    protected $graf; // integer 
    protected $city_id; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $category_id; // integer 
    protected $is_resume; // integer 
    protected $user_id; // integer 
    protected $firm_id; // integer 
    protected $date; // integer 
    protected $country_id; // integer 
    protected $active; // integer 
    protected $type_id; // integer 
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
		return 'catalog_work_ja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, description, category_id, user_id, type_id, slug', 'required'),
			array('id, price, graf, city_id, del, pos, category_id, is_resume, user_id, firm_id, date, country_id, active, type_id, col', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, description, contacts, price, graf, city_id, del, pos, category_id, is_resume, user_id, firm_id, date, country_id, active, type_id, slug, col', 'safe'),
            array('id, name, image, description, contacts, price, graf, city_id, del, pos, category_id, is_resume, user_id, firm_id, date, country_id, active, type_id, slug, col', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'image' => 'Image',
			'description' => 'Description',
			'contacts' => 'Contacts',
			'price' => 'Price',
			'graf' => 'Graf',
			'city_id' => 'City',
			'del' => 'Del',
			'pos' => 'Pos',
			'category_id' => 'Category',
			'is_resume' => 'Is Resume',
			'user_id' => 'User',
			'firm_id' => 'Firm',
			'date' => 'Date',
			'country_id' => 'Country',
			'active' => 'Active',
			'type_id' => 'Type',
			'slug' => 'Slug',
			'col' => 'Col',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('contacts',$this->contacts,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('graf',$this->graf);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('is_resume',$this->is_resume);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('col',$this->col);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}