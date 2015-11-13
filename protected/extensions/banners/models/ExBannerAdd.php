<?php

/**
 * This is the model class for table "ex_banner".
   */
class ExBannerAdd extends ExBanner
{

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
//			'id' => 'ID',
            'type_id' => 'Тип',
            'position_id' => 'Категория',
//            'status_id' => 'Status',
			'name' => 'Название',
			'image' => 'Картинка',
			'url' => 'url',
            'file' => 'Файл',
			'link' => 'Ссылка перехода с банера',
//			'user_id' => 'User id',
//			'through' => 'Through', // !!!
			'count_show' => 'Количество показов',
//            'finish_count_show' => 'Ограничение по количеству показов', // !!!
//			'inner_page' => 'Inner Page',  // !!!
//			'email' => 'Email<br/>для уведомления о окончании',
			'date_add' => 'Дата<br/>начала показа банера',
			'date_finish' => 'Дата окончания<br/>показа банера',
			'pos' => 'Pos',
//            'last_date' => 'Последняя дата просмотра',
//            'default' => 'По умолчанию',
//            'del' => 'Не активный',
		);
	}

}