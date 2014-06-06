<?php

/**
 * This is the model class for table "catalog_firms_en".
   */
class CatalogFirmsEn extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $pos; // integer 
    protected $country_id; // integer 
    protected $city_id; // integer 
    protected $image; // string 
    protected $email; // string 
    protected $www; // string 
    protected $tel; // string 
    protected $del; // integer 
    protected $tours_count; // integer 
    protected $hotels_count; // integer 
    protected $kurorts_count; // integer 
    protected $service_count; // integer 
    protected $fax; // string 
    protected $address; // string 
    protected $category_id; // integer 
    protected $col; // integer 
    protected $slug; // string 
    protected $user_id; // integer 
    protected $active; // integer 
    protected $edit_date; // integer 

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
		return 'catalog_firms_en';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, description, email, edit_date', 'required'),
			array('id, pos, country_id, city_id, del, tours_count, hotels_count, kurorts_count, service_count, category_id, col, user_id, active, edit_date', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>150),
			array('image', 'length', 'max'=>100),
			array('email, www, tel, fax', 'length', 'max'=>50),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, pos, country_id, city_id, image, email, www, tel, del, tours_count, hotels_count, kurorts_count, service_count, fax, address, category_id, col, slug, user_id, active, edit_date', 'safe'),
            array('id, name, description, pos, country_id, city_id, image, email, www, tel, del, tours_count, hotels_count, kurorts_count, service_count, fax, address, category_id, col, slug, user_id, active, edit_date', 'safe', 'on'=>'search'),
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
			'description' => 'Description',
			'pos' => 'Pos',
			'country_id' => 'Country',
			'city_id' => 'City',
			'image' => 'Image',
			'email' => 'Email',
			'www' => 'Www',
			'tel' => 'Tel',
			'del' => 'Del',
			'tours_count' => 'Tours Count',
			'hotels_count' => 'Hotels Count',
			'kurorts_count' => 'Kurorts Count',
			'service_count' => 'Service Count',
			'fax' => 'Fax',
			'address' => 'Address',
			'category_id' => 'Category',
			'col' => 'Col',
			'slug' => 'Slug',
			'user_id' => 'User',
			'active' => 'Active',
			'edit_date' => 'Edit Date',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('www',$this->www,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('tours_count',$this->tours_count);
		$criteria->compare('hotels_count',$this->hotels_count);
		$criteria->compare('kurorts_count',$this->kurorts_count);
		$criteria->compare('service_count',$this->service_count);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('col',$this->col);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('edit_date',$this->edit_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}