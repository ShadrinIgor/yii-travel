<?php

/**
 * This is the model class for table "i18n_translate".
   */
class I18nTranslate extends CCModel
{
    protected $id; // integer 
    protected $language; // string 
    protected $name; // string 
    protected $del; // integer 
    protected $pos; // integer 
    protected $i18n_id; // integer
    protected $translation;

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
		return 'i18n_translate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i18n_id', 'required'),
			array('i18n_id, del, pos', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('translation, language, name, del, pos, i18n_id', 'safe'),
            array('id, language, name, del, pos, i18n_id', 'safe', 'on'=>'search'),
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
			'i18n' => array(self::BELONGS_TO, 'I18n', 'i18n_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'language' => 'Language',
			'translation' => 'Перевод',
			'del' => 'Del',
			'pos' => 'Pos',
			'i18n_id' => 'I18n',
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
		$criteria->compare('language',$this->language,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('i18n_id',$this->i18n_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}