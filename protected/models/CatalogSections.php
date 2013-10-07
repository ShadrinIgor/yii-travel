<?php

/**
 * This is the model class for table "catalog_sections".
   */
class CatalogSections extends CCmodel
{
    protected $id; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $tours; // string 
    protected $info; // string 
    protected $images; // string 
    protected $info_count; // integer 
    protected $tours_count; // integer 
    protected $kurorts_count; // integer 
    protected $images_count; // integer 
    protected $words; // string 
    protected $country_id; // integer 
    protected $baner_l; // string 
    protected $group; // string 

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
			array('tours, info, images, words, baner_l, group', 'required'),
			array('active, pos, info_count, tours_count, kurorts_count, images_count', 'numerical', 'integerOnly'=>true),
			array('name, tours, info, images', 'length', 'max'=>25),
			array('baner_l', 'length', 'max'=>255),
			array('group', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, active, pos, tours, info, images, info_count, tours_count, kurorts_count, images_count, words, country_id, baner_l, group', 'safe', 'on'=>'search'),
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
			'active' => 'Active',
			'pos' => 'Pos',
			'tours' => 'Tours',
			'info' => 'Info',
			'images' => 'Images',
			'info_count' => 'Info Count',
			'tours_count' => 'Tours Count',
			'kurorts_count' => 'Kurorts Count',
			'images_count' => 'Images Count',
			'words' => 'Words',
			'country_id' => 'Country',
			'baner_l' => 'Baner L',
			'group' => 'Group',
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
		$criteria->compare('tours',$this->tours,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('info_count',$this->info_count);
		$criteria->compare('tours_count',$this->tours_count);
		$criteria->compare('kurorts_count',$this->kurorts_count);
		$criteria->compare('images_count',$this->images_count);
		$criteria->compare('words',$this->words,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('baner_l',$this->baner_l,true);
		$criteria->compare('group',$this->group,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}