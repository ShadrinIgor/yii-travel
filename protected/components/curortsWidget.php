<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class curortsWidget extends CWidget
{
    public function run()
    {
        $this->render( "curorts", array(
                    'list'      =>  CatalogKurorts::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>''")->setOrderBy("pos")->setLimit( 12 ) )
            ));
    }
}
