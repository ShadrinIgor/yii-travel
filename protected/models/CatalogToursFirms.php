<?php

/**
 * This is the model class for table "catalog_tours".
   */
class CatalogToursFirms extends CatalogTours
{
 	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, country_id, price', 'search'),
        );
    }


}