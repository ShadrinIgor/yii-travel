<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class firmWidget extends CWidget
{
    var $item;
    public function run()
    {
        $this->render( "firm", array(
                    'tour'      =>  $this->item,
                    'tourCounts'=> CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams(array(":firm_id"=>$this->item->id)) )
            ));
    }
}
