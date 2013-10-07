<?php

/**
 * This is the model class for table "cat_gallery".
   */
class CatGalleryAdd extends CatGallery
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image, catalog, item_id', 'required'),
			array('del, pos, item_id', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			array('name', 'length', 'max'=>150),
			array('catalog', 'length', 'max'=>50),
            array('image, name, catalog, item_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, del, image, pos, name, catalog, item_id', 'safe', 'on'=>'search'),
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
			'image' => 'Image',
		);
	}

}