<?php

/**
 * This is the model class for table "config".
   */
class ConsoleConfigOptions extends ConfigOptions
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, value, key_word', 'required'),
			array('del, pos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('value, key_word', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('name, value, key_word, del, pos', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributePlaceholder()
    {
        return array_merge( parent::attributePlaceholder(),
            array(
                'name' => 'Название настройки',
                'value' => 'Введите значение настройки',
            ));
    }

}