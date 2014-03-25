<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class itemWidget extends CWidget
{
    var $item;
    public function run()
    {
        $this->render( "item", array(
                    'item'      =>  $this->item
            ));
    }
}
