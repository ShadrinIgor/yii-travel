<?php

/**
 * This is the model class for table "catalog_menu".
   */
class CatalogMenu extends CCmodel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $image; // string 
    protected $bimage; // string 
    protected $link; // string 
    protected $del; // integer 
    protected $in_menu; // string 

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
		return 'catalog_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, image, bimage, link', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>25),
			array('image, bimage', 'length', 'max'=>100),
			array('link', 'length', 'max'=>50),
			array('in_menu', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, image, bimage, link, del, in_menu', 'safe', 'on'=>'search'),
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
			'active' => 'Active',
			'pos' => 'Pos',
			'image' => 'Image',
			'bimage' => 'Bimage',
			'link' => 'Link',
			'del' => 'Del',
			'in_menu' => 'In Menu',
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
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('bimage',$this->bimage,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('in_menu',$this->in_menu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}