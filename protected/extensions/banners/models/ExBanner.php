<?php

/**
 * This is the model class for table "ex_banner".
   */
class ExBanner extends CCModel
{
    protected $id; // integer 
    protected $name; // string 
    protected $image; // string
    protected $file; // string
    protected $link; // string
	protected $url; // string	
    protected $position_id; // integer 
    protected $type_id; // integer 
    protected $del; // integer 
    protected $date_add; // string 
    protected $date_finish; // string 
    protected $pos; // integer 
    protected $status_id;// integer
	protected $user_id;// integer

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
		return 'ex_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, position_id, type_id, status_id', 'required'),
			array('user_id, del, pos, position_id, type_id, status_id', 'numerical', 'integerOnly'=>true),
			array('name, image', 'length', 'max'=>50),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => 'Размер файл не должен превышать 5mb',
                'wrongType' => "Неправильный тип загружаемого файл допускается - jpg, gif, png"), // Ограничение по размеру 5mb

            array('file', 'file', 'types'=>'swf', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => 'Размер файл не должен превышать 5mb',
                'wrongType' => "Неправильный тип загружаемого файл допускается - swf"),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('name, image, file, link, url, position_id, type_id, del, date_add, date_finish, status_id, user_id', 'safe'),
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
			'status' => array(self::BELONGS_TO, 'ExBannerStatus', 'status_id'),
			'position_id0' => array(self::BELONGS_TO, 'ExBannerPosition', 'position_id'),
			'type' => array(self::BELONGS_TO, 'ExBannerType', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'type_id' => 'Тип',
            'position_id' => 'Категория',
            'status_id' => 'Status',
			'name' => 'Название',
			'image' => 'Картинка',
			'url' => 'url',
            'file' => 'Файл',
			'link' => 'Ссылка перехода с банера',
			'user_id' => 'User id',
//			'through' => 'Through', // !!!
			'count_show' => 'Количество показов',
            'finish_count_show' => 'Ограничение по количеству показов', // !!!
//			'inner_page' => 'Inner Page',  // !!!
			'email' => 'Email<br/>для уведомления о окончании',
			'date_add' => 'Дата<br/>начала показа банера',
			'date_finish' => 'Дата окончания<br/>показа банера',
			'pos' => 'Pos',
            'last_date' => 'Последняя дата просмотра',
            'default' => 'По умолчанию',
            'del' => 'Не активный',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('default',$this->default);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('through',$this->through,true);
		$criteria->compare('count_show',$this->count_show);
		$criteria->compare('inner_page',$this->inner_page);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_finish',$this->date_finish,true);
		$criteria->compare('finish_count_show',$this->finish_count_show);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(),
                    array(
                         "default"=>"checkbox",
                         "date_add"=>"date",
                         "date_finish"=>"date",
                         "link"=>"url"
                    )
                );
	}
}