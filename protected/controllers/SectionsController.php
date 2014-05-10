<?php

class SectionsController extends Controller
{
    var $description;
    var $keyWord;
    public function init()
    {
        parent::init();
        $this->description = "Разновидности турестического отдыха такие как экстрим, охота и рыбалка, иследования, религия, детские лагеря, отдых в горах";
        $this->keyWord = "Эктримальный туризм, Охота и рыбалка, VIP отдых, Развлекательный туризм, Исследовательский туризм, Религиозный туризм, Детские лагеря, Отдых в горах";
    }

    public function actionIndex()
    {
        $page = (int)Yii::app()->request->getParam( "p", 1 );
        $action = Yii::app()->request->getParam( "action", "t" );

        $activeTab = "";
        $t_page = 1;
        $i_page = 1;
        $c_page = 1;

        if( $action == "t" ){$t_page = $page;$activeTab="s_tours";}
        if( $action == "i" ){$i_page = $page;$activeTab="s_info";}
        if( $action == "c" ){$c_page = $page;$activeTab="s_curorts";}

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
                $infoCategory = "";
                foreach( $item->info as $itemC )
                {
                    if( !empty( $infoCategory ) )$infoCategory .= " OR ";
                    $infoCategory .= " category_id='".$itemC->id."' ";
                }

                $curortsCategory = "";
                foreach( $item->curorts as $itemC )
                {
                    if( !empty( $curortsCategory ) )$curortsCategory .= " OR ";
                    $curortsCategory .= " category_id='".$itemC->id."' ";
                }

                $toursCategory = "";
                foreach( $item->tours as $itemC )
                {
                    if( !empty( $toursCategory ) )$toursCategory .= " OR ";
                    $toursCategory .= " category_id='".$itemC->id."' ";
                }

                Yii::app()->page->title = $item->name;
                $this->render('index',
                    array(
                        "activeTab" =>$activeTab,
                        "item" => $item,
                        "info" => CatalogInfo::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $infoCategory )->setOrderBy("col DESC")->setPage( $t_page )->setLimit( 15 )),
                        "infoCount" => CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions( $infoCategory )),
                        "tours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $toursCategory )->setOrderBy("col DESC")->setPage( $t_page )->setLimit( 15 )),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( $toursCategory )),
                        "curorts" => CatalogKurorts::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $curortsCategory )->setOrderBy("col DESC")->setPage( $t_page )->setLimit( 15 )),
                        "curortsCount" => CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions( $curortsCategory )),
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