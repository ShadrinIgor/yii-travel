<?php

/**
 * This is the model class for table "catalog_firms_service".
   */
class CatalogFirmsServiceAdd extends CatalogFirmsService
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, firm_id, user_id, description', 'required'),
			array('active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, active, pos, del, firm_id, user_id, description', 'safe'),
            array('id, name, active, pos, del, firm_id, user_id, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Название',
			'active' => 'Опубликовать',
			'description' => 'Описание услуги',
		);
	}
}