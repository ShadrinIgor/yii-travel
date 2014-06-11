<?php

/**
 * This is the model class for table "catalog_kurorts_firms_en".
   */
class CatalogKurortsFirmsJa extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $pos; // integer 
    protected $del; // integer 
    protected $firms; // string 
    protected $curorts; // string 
    protected $curorts_count; // integer 

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
		return 'catalog_kurorts_firms_ja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, firms, curorts', 'required'),
			array('id, active, pos, del, curorts_count', 'numerical', 'integerOnly'=>true),
			array('name, firms, curorts', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, active, pos, del, firms, curorts, curorts_count', 'safe'),
            array('id, name, active, pos, del, firms, curorts, curorts_count', 'safe', 'on'=>'search'),
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
			'active' => 'Active',
			'pos' => 'Pos',
			'del' => 'Del',
			'firms' => 'Firms',
			'curorts' => 'Curorts',
			'curorts_count' => 'Curorts Count',
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
		$criteria->compare('del',$this->del);
		$criteria->compare('firms',$this->firms,true);
		$criteria->compare('curorts',$this->curorts,true);
		$criteria->compare('curorts_count',$this->curorts_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}