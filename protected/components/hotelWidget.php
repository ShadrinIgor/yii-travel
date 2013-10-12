<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class hotelWidget extends CWidget
{
    var $item;
    public function run()
    {
        $this->render( "hotel", array(
                    'item'      =>  $this->item
            ));
    }
}
