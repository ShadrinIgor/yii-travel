<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class topButtonWidget extends CWidget
{
    var $type;
    public function run()
    {
        $this->render( "topButton", array(
                    'type'      =>  $this->type
            ));
    }
}
