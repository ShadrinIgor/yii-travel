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
    protected $href; // string 
    protected $category; // integer 
    protected $default; // integer 
    protected $type_id; // integer 
    protected $del; // integer 
    protected $width; // integer 
    protected $height; // integer 
    protected $through; // string 
    protected $count_show; // integer 
    protected $inner_page; // integer 
    protected $email; // string 
    protected $start_date; // string 
    protected $finish_date; // string 
    protected $finish_count_show; // integer 
    protected $pos; // integer 
    protected $status_id; // integer
    protected $last_date;

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
			array('category, type_id', 'required'),
			array('last_date, default, del, width, height, count_show, inner_page, finish_count_show, pos', 'numerical', 'integerOnly'=>true),
			array('name, image, email', 'length', 'max'=>50),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => 'Размер файл не должен превышать 5mb',
                'wrongType' => "Неправильный тип загружаемого файл допускается - jpg, gif, png"), // Ограничение по размеру 5mb

            array('file', 'file', 'types'=>'swf', 'allowEmpty'=>true, 'maxSize' => 1024 * 1024 * 5,
                'tooLarge' => 'Размер файл не должен превышать 5mb',
                'wrongType' => "Неправильный тип загружаемого файл допускается - swf"),

			array('through', 'length', 'max'=>25),
			array('start_date, finish_date', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('last_date, name, image, file, href, category, default, del, type_id, width, height, through, count_show, inner_page, email, start_date, finish_date, finish_count_show, status_id', 'safe'),
			array('id, name, image, href, category, default, type_id, del, width, height, through, count_show, inner_page, email, start_date, finish_date, finish_count_show, pos, status_id', 'safe', 'on'=>'search'),
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
			'category0' => array(self::BELONGS_TO, 'ExBannerCategory', 'category'),
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
            'category' => 'Категория',
            'status_id' => 'Status',
			'name' => 'Название',
			'image' => 'Картинка',
            'file' => 'Файл',
			'href' => 'Ссылка перехода с банера',
			'width' => 'Ширина',
			'height' => 'Высота',
//			'through' => 'Through', // !!!
			'count_show' => 'Количество показов',
            'finish_count_show' => 'Ограничение по количеству показов', // !!!
//			'inner_page' => 'Inner Page',  // !!!
			'email' => 'Email<br/>для уведомления о окончании',
			'start_date' => 'Дата<br/>начала показа банера',
			'finish_date' => 'Дата окончания<br/>показа банера',
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
		$criteria->compare('href',$this->href,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('default',$this->default);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('del',$this->del);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('through',$this->through,true);
		$criteria->compare('count_show',$this->count_show);
		$criteria->compare('inner_page',$this->inner_page);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('finish_date',$this->finish_date,true);
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
                         "start_date"=>"date",
                         "finish_date"=>"date",
                         "href"=>"url"
                    )
                );
	}
}