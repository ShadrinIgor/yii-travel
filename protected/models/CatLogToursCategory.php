<?php

/**
 * This is the model class for table "cat_log_tours_category".
   */
class CatLogToursCategory extends CCModel
{
    protected $id; // integer 
    protected $category_id; // integer 
    protected $count; // integer 
    protected $name; // integer 
    protected $del; // integer 
    protected $pos; // integer 
    protected $date2; // integer 

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
		return 'cat_log_tours_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, date2', 'required'),
			array('category_id, count, name, del, pos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, count, name, del, pos, date2', 'safe'),
            array('id, category_id, count, name, del, pos, date2', 'safe', 'on'=>'search'),
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
			'category_id' => 'Cid',
			'count' => 'Action Cid Show',
			'name' => 'Name',
			'del' => 'Del',
			'pos' => 'Pos',
			'date2' => 'date2 From',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('name',$this->name);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('date2',$this->date2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}