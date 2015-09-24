<?php

/**
 * This is the model class for table "cat_log_tours".
   */
class CatLogToursAll extends CCModel
{
    protected $id; // integer 
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
		return 'cat_log_tours_all';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date2, count', 'required'),
			array(' count, name, del, pos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('count, name, del, pos, date2', 'safe'),
		);
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "date2", "varchar" ) );
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
			'count' => 'Action Show',
			'name' => 'Name',
			'del' => 'Del',
			'pos' => 'Pos',
			'date2' => 'date2',
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
		$criteria->compare('tour_id',$this->tour_id);
		$criteria->compare('count',$this->action_showimage);
		$criteria->compare('name',$this->name);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('date2',$this->date2_from);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}