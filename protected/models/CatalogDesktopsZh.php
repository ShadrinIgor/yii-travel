<?php

/**
 * This is the model class for table "catalog_desktops_zh".
   */
class CatalogDesktopsZh extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $class_name; // string 
    protected $del; // integer 
    protected $image; // string 
    protected $pos; // integer 

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
		return 'catalog_desktops_zh';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name', 'required'),
			array('del, pos', 'numerical', 'integerOnly'=>true),
			array('name, class_name', 'length', 'max'=>50),
			array('image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, class_name, del, image, pos', 'safe'),
            array('id, name, class_name, del, image, pos', 'safe', 'on'=>'search'),
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
			'class_name' => 'Class Name',
			'del' => 'Del',
			'image' => 'Image',
			'pos' => 'Pos',
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
		$criteria->compare('class_name',$this->class_name,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}