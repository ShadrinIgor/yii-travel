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
        $page = (int)Yii::app()->request->getParam( "p", 1 );
        $action = Yii::app()->request->getParam( "action", "t" );

        $t_page = 1;
        $i_page = 1;
        $c_page = 1;
        if( $action == "t" )$t_page = $page;
        if( $action == "i" )$i_page = $page;
        if( $action == "c" )$c_page = $page;

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
                $toursCategory = "";
                $categoryList = $item->tours;
                foreach( $categoryList as $itemC )
                {
                    if( !empty( $toursCategory ) )$toursCategory .= " OR ";
                    $toursCategory .= " category_id='".$itemC->id."' ";
                }

                Yii::app()->page->title = $item->name;
                $this->render('index',
                    array(
                        "item" => $item,
                        "activeTab" => "s_tours",
                        "info" => $item->info,
                        "tours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $toursCategory )->setPage( $t_page )->setLimit( 15 )),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( $toursCategory )),
                        "curorts" => $item->curorts,
                        "t_page" => $t_page,
                        "i_page" => $i_page,
                        "c_page" => $c_page,
                        "offset" => 15
                    ));
            }
                else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");

    }
}