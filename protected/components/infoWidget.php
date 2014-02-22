<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class infoWidget extends CWidget
{
    var $class;
    var $link;
    public function run()
    {
        $className = $this->class;
        $this->render( "infoWidget", array(
                    'link' => SiteHelper::createUrl( $this->class ),
                    'list' => $className::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>''")->setOrderBy("pos DESC")->setLimit( 12 ) )
            ));
    }
}
