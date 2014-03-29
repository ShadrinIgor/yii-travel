<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class infoOneWidget extends CWidget
{
    var $item;
    public function run()
    {
        $this->render( "info", array(
                    'item' => $this->item,
            ));
    }
}
