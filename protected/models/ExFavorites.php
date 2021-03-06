<?php

/**
 * This is the model class for table "ex_favorites".
   */
class ExFavorites extends CCModel
{
    protected $id; // integer 
    protected $user_id; // integer 
    protected $catalog; // string 
    protected $item_id; // integer 
    protected $date; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $name; // string 

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
		return 'ex_favorites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, catalog, item_id, date, name', 'required'),
			array('item_id, date, del, pos', 'numerical', 'integerOnly'=>true),
			array('catalog', 'length', 'max'=>50),
			array('name', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, catalog, item_id, date, del, pos, name', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'catalog' => 'Catalog',
			'item_id' => 'Item',
			'date' => 'Date',
			'del' => 'Del',
			'pos' => 'Pos',
			'name' => 'Name',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('catalog',$this->catalog,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}