<?php

class SectionsController extends Controller
{
    var $description;
    var $keyWord;
    public function init()
    {
        parent::init();
        $this->description = "Туристический страны, описание, туристические достопримечательности";
        $this->keyWord = "туристические страны, Турция, Египет, Болгария, Малайзия, ОАЭ, Таиланд";
    }

    public function actionIndex()
    {
        $tab = "";
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) && $_GET[$key]!="null" )continue;
            $item = CatalogSections::fetchBySlug( $key );
            if( $item->id >0 )break;
        }

        if( $item && $item->id >0)
        {
            Yii::app()->page->setInfo( array( "description"=>$item->name.",".$this->description, "keyWord"=>$item->name.",".$this->keyWord ) );
            if( !empty( $item ) && $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
                $this->render('index',
                    array(
                        "item" => $item,
                        "activeTab" => "s_tours",
                        "info" => $item->info,
                        "tours" => $item->tours,
                        "curorts" => $item->curorts,
                    ));
            }
                else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");

    }
}