<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 04.11.12
 * Time: 2:29
 * To change this template use File | Settings | File Templates.
 */
class PageInit extends CApplicationComponent
{
    private $page;
    var $tag_params;
    var $slug;
    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.page.models.*");
        $this->page = new CatalogPages();
    }

    public function renderTags( $slug )
    {
        if( Yii::app()->controller->beginCache( $slug."-page-".Yii::app()->getLanguage(), array('duration'=>3600*24*3) ) )
        {
            $params = $this->tag_params;
            if( !empty( $params[$slug] ) )$paramArray = $params[$slug];
                elseif( !empty( $params["default"] ) )$paramArray = $params["default"];

            $listClass = array( "key01", "key02", "key03", "key04", "key05", "key06" );

            if( !empty( $paramArray ) )
            {
                $listTags = array();
                foreach( $paramArray as $key=>$value )
                {
                    $modelClass = SiteHelper::getCamelCase( $key );
                    $sql = "del=0";
                    if( !empty( $value[2] ) )$sql .= " AND ".$value[2];

                    $link = SiteHelper::createUrl( $value[0] );
                    $listItems = $modelClass::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $sql )->setLimit( $value[1] )->setOrderBy( "id DESC" ) );
                    foreach( $listItems as $item )
                    {
                        if( $item->slug )
                        {
                            $randClass = array_rand( $listClass, 1 );
                            $item->name = SiteHelper::getSubTextOnWorld( $item->name, 60 );
                            $listTags[] = '<a href="'.$link."/".$item->slug.'.html" title="'.SiteHelper::getStringForTitle( $item->name ).'" class="'.$listClass[ $randClass ].'">'.$item->name.'</a>';
                        }
                    }
                }

                shuffle( $listTags );
                shuffle( $listTags );
                foreach( $listTags as $key=>$item )
                {
                    echo $item." ";
                }
            }

            Yii::app()->controller->endCache();
        }
    }

    public function getInfo( $key )
    {
        $value = null;
        if( property_exists( $this->page, $key) )$value = $this->page->$key;
        return $value;
    }

    public function setInfo( array $values )
    {
        foreach( $values as $key=>$value )
            if( property_exists( $this->page, $key) )
                $this->page->$key = $value;
    }

    // ---- Title
    public function setTitle( $values )
{
    $this->setInfo( array( "title"=>$values ) );
}

    public function getTitle( )
    {
        return $this->getInfo( "title" )." :: ".Yii::t( "models", "Туристический портал Узбекистана");
    }
    // ---- end of Title


    // ---- Title
    public function setDescription( $values )
    {
        $this->setInfo( array( "title"=>$values ) );
    }

    public function getDescription( )
    {
        return $this->getInfo( "title" ).",". $this->getInfo( "description" );
    }
    // ---- end of Title


    // ---- Title
    public function setKeyWord( $values )
    {
        $this->setInfo( array( "keyWord"=>$values ) );
    }

    public function getKeyWord( )
    {
        return $this->getInfo( "keyWord" );
    }
    // ---- end of Title

}
