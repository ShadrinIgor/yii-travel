<?php

/**
 * This is the model class for table "catalog_work".
 */
class CatalogWorkResumeAdd extends CatalogWorkAdd
{

    public function attributePlaceholder()
    {
        return array(
            'name' => 'например: Ищу работу менеджером по продажам',
            'contacts' => 'тут необходимо указать контактные телефоны',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Должность резюме',
            'category_id' => 'Кактегория резюме',
            'country_id' => Yii::t("page", "Страна"),
            'city_id' => 'Город',
            'image' => 'Фото',
            'graf' => 'График',
            'price' => 'Заработная плата',
            'contacts' => 'Контакты',
            'description' => 'Описание резюме',
        );
    }
}