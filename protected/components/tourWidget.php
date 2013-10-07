<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class tourWidget extends CWidget
{
    var $item;
    public function run()
    {
        $this->render( "tour", array(
                    'tour'      =>  $this->item
            ));
    }
}
