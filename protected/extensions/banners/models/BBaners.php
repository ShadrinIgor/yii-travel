<?php

/**
 * This is the model class for table "b_banners".
   */
class BBaners extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $image; // string 
    protected $href; // string 
    protected $category; // integer 
    protected $default; // integer 
    protected $type; // integer 
    protected $width; // integer 
    protected $height; // integer 
    protected $through; // string 
    protected $count_show; // integer 
    protected $inner_page; // integer 
    protected $email; // string 
    protected $start_date; // string 
    protected $finish_date; // string 
    protected $finish_count_show; // integer 
    protected $active; // integer 
    protected $del; // integer 

    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'b_banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('default, type, width, height, count_show, inner_page, finish_count_show, active, del', 'numerical', 'integerOnly'=>true),
			array('name, image, href, email', 'length', 'max'=>50),
			array('through', 'length', 'max'=>25),
			array('start_date, finish_date', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, href, category, default, type, width, height, through, count_show, inner_page, email, start_date, finish_date, finish_count_show, active, del', 'safe', 'on'=>'search'),
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
			'category0' => array(self::BELONGS_TO, 'BCategory', 'category'),
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
			'href' => 'Href',
			'category' => 'Category',
			'default' => 'Default',
			'type' => 'Type',
			'width' => 'Width',
			'height' => 'Height',
			'through' => 'Through',
			'count_show' => 'Count Show',
			'inner_page' => 'Inner Page',
			'email' => 'Email',
			'start_date' => 'Start Date',
			'finish_date' => 'Finish Date',
			'finish_count_show' => 'Finish Count Show',
			'active' => 'Active',
			'del' => 'Del',
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
		$criteria->compare('href',$this->href,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('default',$this->default);
		$criteria->compare('type',$this->type);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('through',$this->through,true);
		$criteria->compare('count_show',$this->count_show);
		$criteria->compare('inner_page',$this->inner_page);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('finish_date',$this->finish_date,true);
		$criteria->compare('finish_count_show',$this->finish_count_show);
		$criteria->compare('active',$this->active);
		$criteria->compare('del',$this->del);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}