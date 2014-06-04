<?php

/**
 * This is the model class for table "catalog_work".
   */
class CatalogWorkVacansyAdd extends CatalogWorkAdd
{
    public function attributePlaceholder()
    {
        return array_merge( parent::attributePlaceholder(),
            array(
                'name' => Yii::t("models", 'срочно требуются сотрудники в фирму'),
                'description' => Yii::t("models", 'без вредных привычек, стаж не менее года, не обходимые навыки')
            ));
    }
}