<?php

class CatalogFilter extends CFilter
{
    protected function preFilter($filterChain){
        $catalog = Yii::app()->request->getParam("catalog", "");
        $id = Yii::app()->request->getParam("id", 0);

        if( empty( $catalog ) )
        {
            $this->render('error', "Error");
            return false;
        }
                           else return true;
    }

    protected function postFilter($filterChain)
    {
        echo 'postFilter';exit;
        return true;
    }
}
