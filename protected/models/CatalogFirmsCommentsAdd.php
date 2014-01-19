<?php

/**
 * This is the model class for table "catalog_firms_coments".
   */
class CatalogFirmsCommentsAdd extends CatalogFirmsComments
{
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, fio, firm_id, user_id, description', 'required'),
			array('active, is_new, pos, firm_id, user_id,  date, del', 'numerical', 'integerOnly'=>true),
			array('name, fio', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('is_new, name, fio, active, pos, date, del, firm_id, user_id, description', 'safe'),
			array('id, name, fio, active, pos, date, del, firm_id, user_id, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'fio' => 'Имя',
			'name' => 'Заголовок',
			'description' => 'Текст',
		);
	}

}