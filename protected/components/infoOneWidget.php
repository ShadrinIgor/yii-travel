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
    var $link = "touristInfo";

    public function run()
    {
        $images = ImageHelper::getImages( $this->item, 1 );
        $this->render( "info", array(
                    'link'   => $this->link,
                    'images' => $images,
                    'item'   => $this->item,
            ));
    }
}
