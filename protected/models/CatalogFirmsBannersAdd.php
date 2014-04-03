<?php

/**
 * This is the model class for table "catalog_firms_banners".
   */
class CatalogFirmsBannersAdd extends CatalogFirmsBanners
{
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date, type_id, firm_id, user_id, position_id', 'required'),
			array('type_id, file, firm_id, user_id, date, active, pos, col, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('link, type_id, file', 'length', 'max'=>255),
            array( 'name', "checkFile" ),
            array('name, link, type_id, file, date, firm_id, user_id, position_id, pos, col, del', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, link, type_id, file, date, firm_id, user_id, position_id, active, pos, col, del', 'safe', 'on'=>'search'),
		);
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
        );
    }
}