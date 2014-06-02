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
        $tab = Yii::app()->request->getParam( "tab", "" );
        $page = (int)Yii::app()->request->getParam( "p", 1 );
        $action = Yii::app()->request->getParam( "action", "t" );
        $country = Yii::app()->request->getParam( "country", "" );
        $category = Yii::app()->request->getParam( "category", "" );
        $ccategory = Yii::app()->request->getParam( "ccategory", "" );
        $icategory = Yii::app()->request->getParam( "icategory", "" );

        $activeTab = "";
        $t_page = 1;
        $i_page = 1;
        $c_page = 1;

        if( $action == "t" ){$t_page = $page;$activeTab="s_tours";}
        if( $action == "i" || $tab == "info"){$i_page = $page;$activeTab="s_info";}
        if( $action == "c" || $tab == "curorts" ){$c_page = $page;$activeTab="s_curorts";}

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
                $infoCategory = " 1=1 ";
                $infoSQL = " 1=1 ";

                if( !empty( $icategory ) )
                    $infoCategory .= " AND category_id = ( SELECT id FROM catalog_info_category WHERE slug='".$icategory."' )";

                $i=0;
                if( sizeof( $item->info ) >0 )
                {
                    $infoCategory .= " AND ( ";
                    $infoSQL .= " AND ( ";
                    foreach( $item->info as $itemC )
                    {
                        if( $i>0 )
                        {
                            $infoCategory .= " OR ";
                            $infoSQL .= " OR ";
                        }
                        $infoCategory .= " category_id='".$itemC->id."' ";
                        $infoSQL .= " category_id='".$itemC->id."' ";
                        $i++;
                    }
                    $infoCategory .= " ) ";
                    $infoSQL .= " ) ";
                }

                $curortsCategory = " 1=1 ";
                $kurortsSQL = " 1=1 ";

                if( !empty( $ccategory ) )
                    $curortsCategory .= " AND category_id = ( SELECT id FROM catalog_kurorts_category WHERE slug='".$ccategory."' )";

                if( sizeof( $item->curorts ) >0 )
                {
                    $curortsCategory .= " AND ( ";
                    $kurortsSQL .= " AND ( ";

                    $i=0;
                    foreach( $item->curorts as $itemC )
                    {
                        if( $i > 0 )
                        {
                            $curortsCategory .= " OR ";
                            $kurortsSQL.=" OR ";
                        }
                        $curortsCategory .= " category_id='".$itemC->id."' ";
                        $kurortsSQL .= " category_id='".$itemC->id."' ";
                        $i++;
                    }
                    $curortsCategory .= " ) ";
                    $kurortsSQL .= " ) ";

                    $cororts = CatalogKurorts::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $curortsCategory )->setOrderBy("col DESC")->setPage( $c_page )->setLimit( 15 ));
                    $curortsCount = CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions( $curortsCategory ) );
                }
                    else
                    {
                        $cororts = array();
                        $curortsCount = 0;
                    }

                $toursCategory = " 1=1 ";
                $toursSQL = " 1=1 ";
                if( $item->country_id->id > 0 )
                {
                    $toursCategory .= " AND country_id = '".$item->country_id->id."'";
                    $toursSQL .= " AND country_id = '".$item->country_id->id."'";
                }

                if( !empty( $country ) )
                    $toursCategory .= " AND country_id = ( SELECT id FROM catalog_country WHERE slug='".$country."' )";

                if( !empty( $category ) )
                    $toursCategory .= " AND category_id = ( SELECT id FROM catalog_tours_category WHERE slug='".$category."' )";

                if( sizeof( $item->tours ) >0 )
                {
                    $toursCategory .= " AND ( ";
                    $toursSQL .=  " AND ( ";
                }
                $i=0;
                foreach( $item->tours as $itemC )
                {
                    if( $i >0 )
                    {
                        $toursCategory .= " OR ";
                        $toursSQL .= " OR ";
                    }
                    $toursCategory .= " category_id='".$itemC->id."' ";
                    $toursSQL .= " category_id='".$itemC->id."' ";
                    $i++;
                }

                if( sizeof( $item->tours ) >0 )
                {
                    $toursCategory .= " ) ";
                    $toursSQL .=  " ) ";
                }

                // Одно исключение для детских лагерей
                if( $item->id == 7 )
                {
                    $detCount = CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions( $curortsCategory ));
                }
                    else $detCount = 0;

                Yii::app()->page->title = $item->name;
                $this->render('index',
                    array(
                        "icategory" =>$icategory,
                        "ccategory" =>$ccategory,
                        "category" =>$category,
                        "country" =>$country,
                        "activeTab" =>$activeTab,
                        "item" => $item,
                        "infoSQL" => $infoSQL,
                        "info" => CatalogInfo::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $infoCategory )->setOrderBy("col DESC")->setPage( $i_page )->setLimit( 15 )),
                        "infoCount" => CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions( $infoCategory )),
                        "toursSQL" =>$toursSQL,
                        "tours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $toursCategory )->setOrderBy("col DESC")->setPage( $t_page )->setLimit( 15 )),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( $toursCategory )),
                        "kurortsSQL" => $kurortsSQL,
                        "curorts" => $cororts,
                        "curortsCount" => $curortsCount,
                        "detCount" => $detCount,
                        "t_page" => $t_page,
                        "i_page" => $i_page,
                        "c_page" => $c_page,
                        "offset" => 15
                    ));
            }
                else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );
        }
            else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );

    }
}