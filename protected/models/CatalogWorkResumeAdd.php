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
            'name' => Yii::t("models", 'Должность резюме'),
            'category_id' => Yii::t("models", 'Категория резюме'),
            'country_id' => Yii::t("page", "Страна"),
            'city_id' => Yii::t("page", "Город"),
            'image' => Yii::t("models", "Фото" ),
            'graf' => Yii::t("models", 'График'),
            'price' => Yii::t("models", 'Заработная плата' ),
            'contacts' => Yii::t("models", "Контакты" ),
            'description' => Yii::t("models", 'Описание резюме'),
        );
    }
}