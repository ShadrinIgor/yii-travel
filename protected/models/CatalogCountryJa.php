<?php

/**
 * This is the model class for table "catalog_country_Ja".
   */
class CatalogCountryJa extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $pos; // integer 
    protected $del; // integer 
    protected $description; // string 
    protected $flag; // string 
    protected $image; // string 
    protected $name_2; // string 
    protected $baner; // string 
    protected $slug; // string 
    protected $col; // integer 
    protected $active; // integer 
    protected $cooperation_id; // integer 

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
		return 'catalog_country_ja';
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
			array('pos, del, col, active, cooperation_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>25),
			array('flag, image', 'length', 'max'=>100),
			array('name_2, slug', 'length', 'max'=>50),
			array('baner', 'length', 'max'=>255),
            array('name, pos, del, description, flag, image, name_2, baner, slug, col, active, cooperation_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, pos, del, description, flag, image, name_2, baner, slug, col, active, cooperation_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically gJaerated below.
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
			'pos' => 'Pos',
			'del' => 'Del',
			'description' => 'Description',
			'flag' => 'Flag',
			'image' => 'Image',
			'name_2' => 'Name 2',
			'baner' => 'Baner',
			'slug' => 'Slug',
			'col' => 'Col',
			'active' => 'Active',
			'cooperation_id' => 'Cooperation',
		);
	}

	/**
	 * Retrieves a list of models based on the currJat search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('del',$this->del);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('flag',$this->flag,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('name_2',$this->name_2,true);
		$criteria->compare('baner',$this->baner,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('col',$this->col);
		$criteria->compare('active',$this->active);
		$criteria->compare('cooperation_id',$this->cooperation_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}