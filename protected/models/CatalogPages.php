<?php

/**
 * This is the model class for table "catalog_pages".
   */
class CatalogPages extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $tags; // string
    protected $del; // string
    protected $pos; // string

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
		return 'catalog_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, tags', 'required'),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('del, pos, name, tags', 'safe' ),
            array('id, name, tags', 'safe', 'on'=>'search'),
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

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "tags" => "visual_textarea" ) );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'tags' => 'Tags',
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
		$criteria->compare('tags',$this->tags,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}