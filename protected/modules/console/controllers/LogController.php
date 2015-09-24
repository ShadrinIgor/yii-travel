<?php

class LogController extends ConsoleController
{
    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(  )
	{
        Yii::app()->page->title = "Лог по турам";


        if( $this->beginCache( "console_log_tours", array('duration'=>3600*12) ) )
        {
            $listTours = CatLogToursAll::fetchAll(DBQueryParamsClass::CreateParams()->setOrderBy("date2")->setLimit(50)->setCache(0));
            $listToursParams = CatLogToursParams::fetchAll(DBQueryParamsClass::CreateParams()->setOrderBy("date2")->setLimit(50)->setCache(0));

            $rows = "";
            for ($i = 0; $i < sizeof($listTours); $i++) {
                if (!empty($rows)) $rows .= ",";
                $rows .= "['" . date("d.m", strtotime($listTours[$i]->date2)) . "', " . $listTours[$i]->count . ", " . $listToursParams[$i]->count_category . ", " . $listToursParams[$i]->count_country . " ]";
            }

            $this->render("index", array("rows" => $rows, "listToursParams"=>$listToursParams));
            $this->endCache();
        }
	}

    public function actionToursCountry()
    {
        Yii::app()->page->title = "Лог по турам";

        if( $this->beginCache( "console_log_tours_country", array('duration'=>3600*12) ) )
        {
            $list = CatLogToursCountry::sql( "SELECT log.count, c.name FROM cat_log_tours_country log, catalog_country c WHERE log.date2='".date("Y-m")."' AND c.id = log.country_id ORDER BY log.count DESC" );

            $rows = "";
            for ($i = 0; $i < sizeof($list); $i++)
            {
                if (!empty($rows)) $rows .= ",";
                $rows .= "['". $list[$i]["name"] ."', ". $list[$i]["count"] .", 0, '#3366cc' ]";
            }

            $this->render("toursCountry", array("rows" => $rows));
            $this->endCache();
        }
    }

    public function actionToursCategory()
    {
        Yii::app()->page->title = "Лог по турам";

        if( $this->beginCache( "console_log_tours_category", array('duration'=>3600*12) ) )
        {
            $list = CatLogToursCountry::sql( "SELECT log.count, c.name FROM cat_log_tours_category log, catalog_tours_category c WHERE log.date2='".date("Y-m")."' AND c.id = log.category_id ORDER BY log.count DESC" );

            $rows = "";
            for ($i = 0; $i < sizeof($list); $i++)
            {
                if (!empty($rows)) $rows .= ",";
                $rows .= "['". $list[$i]["name"] ."', ". $list[$i]["count"] .", 0, '#3366cc' ]";
            }

            $this->render("toursCategory", array("rows" => $rows));
            $this->endCache();
        }
    }

};