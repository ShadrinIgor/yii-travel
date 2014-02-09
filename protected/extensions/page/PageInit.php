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
    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.page.models.*");

        $this->page = new page();
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
        return $this->getInfo( "title" )." :: ".Yii::app()->params["titleName"];
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
