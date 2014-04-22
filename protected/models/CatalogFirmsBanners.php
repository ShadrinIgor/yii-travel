<?php

/**
 * This is the model class for table "catalog_firms_banners".
   */
class CatalogFirmsBanners extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $link; // string 
    protected $type_id; // integer 
    protected $file; // string 
    protected $date; // integer 
    protected $firm_id; // integer 
    protected $user_id; // integer 
    protected $active; // integer 
    protected $pos; // integer 
    protected $col; // integer 
    protected $del; // integer 
    protected $position_id; // integer 

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
		return 'catalog_firms_banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type_id, file, date, firm_id, user_id, position_id', 'required'),
			array('date, active, pos, col, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('link, file', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('file, name, link, type_id, file, date, firm_id, user_id, active, pos, position_id, col, del', 'safe'),
            array('id, name, link, type_id, file, date, firm_id, user_id, active, position_id, pos, col, del', 'safe', 'on'=>'search'),
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
			'position' => array(self::BELONGS_TO, 'CatalogFirmsBannersPosition', 'position_id'),
			'user' => array(self::BELONGS_TO, 'CatalogUsers', 'user_id'),
			'firm' => array(self::BELONGS_TO, 'CatalogFirms', 'firm_id'),
			'type' => array(self::BELONGS_TO, 'CatalogFirmsBannersType', 'type_id'),
		);
	}

    public function checkFile()
    {
        $catalog = "CatalogFirmsBannersAdd";
        if( !$this->hasErrors()   )
        {
            // Обрабатываем файл только есть он до этого небыл закачен и не пуст масив $_FILES
            if( empty( $_POST[$catalog]["old_file"] ) && !empty( $_FILES[$catalog]["tmp_name"]["file"] ) )
            {
                if( empty( $_FILES[$catalog]["tmp_name"]["file"] ) )$this->addError( "Ошибка закачивания", "Произошла ошибка закачивания" );
                if( !empty( $_FILES[$catalog]["error"]["file"] ) )$this->addError( "Ошибка закачивания", $_FILES[$catalog]["tmp_name"]["file"]["error"] );
                if( $_FILES[$catalog]["size"]["file"] > 5242880 )$this->addError( "Ошибка закачивания", "Размер закачиваемого файла не должен превышать 5mb" );
                if( $this->type_id->id == 2 && $_FILES[$catalog]["type"]["file"] != "application/x-shockwave-flash" )$this->addError( "Ошибка закачивания", "Для динамичного баннера допускается только файлы типа *.SWF" );
                if( $this->type_id->id == 1 && $_FILES[$catalog]["type"]["file"] != "image/jpeg" )$this->addError( "Ошибка закачивания", "Для статичного баннера допускается только файлы типа JPG | JPEG" );
            }
        }
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Название',
			'link' => 'Ссылка',
			'type_id' => 'Тип баннера',
            'position_id' => 'Позиция баннера',
			'file' => 'Файл',
            'firm_id' => 'Фирма',
			'active' => 'Опубликовать',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('col',$this->col);
		$criteria->compare('del',$this->del);
		$criteria->compare('position_id',$this->position_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}