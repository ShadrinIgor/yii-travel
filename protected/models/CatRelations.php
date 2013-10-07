<?php

/**
 * This is the model class for table "cat_relations".
   */
class CatRelations extends CCModel
{
    protected $id; // integer 
    protected $leftId; // integer 
    protected $rightId; // integer 
    protected $leftClass; // string 
    protected $rightClass; // string
    protected $del; // integer
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
		return 'cat_relations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leftId, rightId, leftClass, rightClass', 'required'),
			array('leftId, rightId', 'numerical', 'integerOnly'=>true),
			array('leftClass, rightClass', 'length', 'max'=>255),
            array('leftClass', 'checkExistParams'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('leftId, rightId, leftClass, rightClass', 'safe', 'on'=>'search'),
		);
	}

    public function checkExistParams( $attribute,$params )
    {
        if( !$this->hasErrors() )
        {
            if( !class_exists( $this->leftClass ) )$this->addError("Ошибка сохранения связей", "Неверное указанно значение Left Class");
            if( !$this->hasErrors() && !class_exists( $this->rightClass ) )$this->addError("Ошибка сохранения связей", "Неверное указанно значение Right Class");
            if( !$this->hasErrors() )
            {
                $leftClassName = $this->leftClass;
                $leftModel = $leftClassName::fetch( $this->leftId );

                if( $leftModel->id >0 )
                {
                    $rightClassName = $this->rightClass;
                    $rightModel = $rightClassName::fetch( $this->rightId );
                    if( $rightModel->id >0 )
                    {
                        $catRelation = CatRelations::findByAttributes( array( "leftId"=>$this->leftId, "rightId"=>$this->rightId, "leftClass"=>$this->leftClass, "rightClass"=>$this->rightClass ) );
                        if( sizeof( $catRelation )>0 )$this->addError("Ошибка сохранения связей", "Запись с указанными параметрами уже зарегистрирована в базе");
                    }
                        else $this->addError("Ошибка сохранения связей", "Неверное указанно значение Right ID");
                }
                    else $this->addError("Ошибка сохранения связей", "Неверное указанно значение Left ID");
            }
        }
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
			'leftId' => 'Left',
			'rightId' => 'Right',
			'leftClass' => 'Left Class',
			'rightClass' => 'Right Class',
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
		$criteria->compare('leftId',$this->leftId);
		$criteria->compare('rightId',$this->rightId);
		$criteria->compare('leftClass',$this->leftClass,true);
		$criteria->compare('rightClass',$this->rightClass,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}