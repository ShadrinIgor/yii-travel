<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class infoWidget extends CWidget
{
    var $item;
    public function run()
    {
        $this->render( "info", array(
                    'item'      =>  $this->item
            ));
    }
}
