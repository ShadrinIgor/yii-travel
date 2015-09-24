<?php

/**
 * This is the model class for table "subscribe_status".
   */
class SubscribeTableUsers extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $del; // integer 
    protected $pos; // integer


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscribe_table_users';
	}

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['name', 'required'],
			['del, pos', 'numerical', 'integerOnly'=>true],
			['name', 'length', 'max'=>150],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			['name, del, pos', 'safe'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
            'pos' => 'Pos',
            'del' => 'Del',
		];
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
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}
}