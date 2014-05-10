<?php

/**
 * This is the model class for table "catalog_firms_items".
   */
class CatalogFirmsItemsAdd2 extends CatalogFirmsItemsAdd
{
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, date, user_id', 'required'),
			array('date, active, pos, del', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
            array('name, description, date, firm_id, user_id, active, slug', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, date, firm_id, user_id, active, pos, del', 'safe', 'on'=>'search'),
		);
	}

}