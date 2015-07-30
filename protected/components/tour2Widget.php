<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class tour2Widget extends CWidget
{
    var $items;
    var $url;
    public function run()
    {
        $this->render( "catalog_tours", array(
                    'items'      =>  $this->items,
                    'url'      =>  $this->url
            ));
    }
}
