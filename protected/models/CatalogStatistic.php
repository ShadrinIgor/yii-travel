<?php

/**
 * This is the model class for table "catalog_statistic".
   */
class CatalogStatistic extends CCmodel
{
    protected $id; // integer 
    protected $name; // string 
    protected $description; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $operation; // string 
    protected $id_num; // string 
    protected $cat_id; // string 

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
		return 'catalog_statistic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operation, id_num, cat_id', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name, id_num, cat_id', 'length', 'max'=>25),
			array('operation', 'length', 'max'=>150),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, active, pos, del, operation, id_num, cat_id', 'safe', 'on'=>'search'),
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
			'del' => 'Del',
			'operation' => 'Operation',
			'id_num' => 'Id Num',
			'cat_id' => 'Cat',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('operation',$this->operation,true);
		$criteria->compare('id_num',$this->id_num,true);
		$criteria->compare('cat_id',$this->cat_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}