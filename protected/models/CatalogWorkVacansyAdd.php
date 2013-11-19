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
                'name' => 'срочно тебуются сотрудники в фирму',
                'description' => 'без вредных привычек, стаж не менее года, необходиммые навыки'
            ));
    }
}