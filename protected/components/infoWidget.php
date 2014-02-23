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
    var $title;
    var $category_id;
    public function run()
    {
        if( $this->beginCache( 'widgetInfo_'.$this->class.$this->category_id, array('duration'=>3600) ) ) :
            $className = $this->class;

            if( $this->category_id>0 )$dopCondition = " AND category_id='".(int)$this->category_id."'";
                                 else $dopCondition = "";

            $this->render( "infoWidget", array(
                        'title' => $this->title,
                        'link' => SiteHelper::createUrl( $this->link."/description" ),
                        'linkAll' => SiteHelper::createUrl( $this->link ),
                        'list' => $className::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>''".$dopCondition)->setOrderBy("pos DESC")->setLimit( 9 ) )
                ));
            $this->endCache();
        endif;
    }
}
