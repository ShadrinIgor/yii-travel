<?php

class SubscribeTableController extends ConsoleController
{
    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex( )
	{
        Yii::app()->page->title = "Таблица рассылки";
        $action = Yii::app()->request->getParam("action", "");

        if( $action == "recheck" )$this->recheck();

        $list = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "date2, id" )->setLimit(-1)->setCache(0) );
        $this->render( "index", [ "list"=>$list ] );
	}

    public function recheck()
    {
        $indexDay = date("m")+1;
        $countDay = 0;
        $list = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1)->setConditions("active=1")->setOrderBy("date2") );
        foreach( $list as $item )
        {
            // Определяем дату
            if( $indexDay == 0 )
            {
                if ($indexDay > 4)
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 6 - date("w"), date("Y"));
                    $countDay += 6 - date("w");
                }
                else
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 4 - date("w"), date("Y"));
                    $countDay += 4 - date("w");
                }

                $date = date("Y-m-d", $makeTime );
                $indexDay = date("w", $makeTime );
            }
            else
            {
                if( $indexDay == 1 )
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 3, date("Y"));
                    $indexDay = 4;
                    $countDay += 3;
                }
                else
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 4, date("Y"));
                    $indexDay = 1;
                    $countDay += 4;
                }

                $date = date("Y-m-d", $makeTime );
            }

            $item->date2 = $date;
            $item->save();
        }
    }

    public function actionGeneration()
    {
        $countryList = CatalogCountry::sql( "SELECT c.*, sum(l.count) FROM catalog_country c, cat_log_tours_country l WHERE c.id = l.country_id GROUP BY l.country_id ORDER BY sum(l.count) DESC LIMIT 16" );
        $categoryList = CatalogToursCategory::sql( "SELECT c.*, sum(l.count) FROM catalog_tours_category c, cat_log_tours_category l WHERE c.id = l.category_id GROUP BY l.category_id ORDER BY sum(l.count) DESC LIMIT 16" );

        /*
         + Сначала выстакиваем популярыне странц
         + Затем вытаскиваем поплярные категории
          + Чередуем рассылки
         Взависимости от странцы выбираем пользователей - если узбекистан то всем если остальные страны то толкько по Узбекистана и Узбекистан агенства
         */

        $indexDay = 0;

        $countDay = 0;
        $countryCount = 0;
        $categoryCount = 0;
        for( $i=0;$i<( sizeof( $countryList ) + sizeof($categoryList) );$i++ )
        {
            $county_Id = 0;
            $category_id = 0;
            $subject = "";

            if( $i % 2 >0 )
            {
                $category_id = $categoryList[ $categoryCount ]["id"];
                $subject = $categoryList[ $categoryCount ]["name"];
                $categoryCount++;
            }
                else
            {
                $county_Id =  $countryList[ $countryCount ]["id"];
                $subject = !empty( $countryList[ $countryCount ]["title"] ) ? $countryList[ $countryCount ]["title"] : $countryList[ $countryCount ]["name"];
                $countryCount++;
            }

            // Определяем дату
            if( $indexDay == 0 )
            {
                if ($indexDay > 4)
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 6 - date("w"), date("Y"));
                    $countDay += 6 - date("w");
                }
                else
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 4 - date("w"), date("Y"));
                    $countDay += 4 - date("w");
                }

                $date = date("Y-m-d", $makeTime );
                $indexDay = date("w", $makeTime );
            }
            else
            {
                if( $indexDay == 1 )
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 3, date("Y"));
                    $indexDay = 4;
                    $countDay += 3;
                }
                else
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 4, date("Y"));
                    $indexDay = 1;
                    $countDay += 4;
                }

                $date = date("Y-m-d", $makeTime );
            }

            $new = new SubscribeTable();
            $new->date2 = $date;
            $new->country_id = $county_Id;
            $new->category_id = $category_id;
            $new->name = $subject;
            if( !$new->save() )
            {
                print_r($new->getErrors());
                print_r( $new );
            }
        }

        $list = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "date2, id" )->setLimit(-1)->setCache(0) );
        $this->render( "index", [ "list"=>$list ] );
    }

    public function actionEdit()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        $model = SubscribeTable::fetch( $id );

        if( !empty( $_POST["SubscribeTable"] ) )
        {
            $model->setAttributesFromArray( $_POST["SubscribeTable"] );
            if( $model->saveWithRelation() )
            {
                $model->formMessage = "Запись успешно сохранена";
            }
        }

        if( $id >0 )
        {
            $userItems = SubscribeTableUsers::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0)->setOrderBy("name")->setLimit(-1) );
            $relations = RelationHelper::getRelationLeftItems( $model, "SubscribeTableUsers" );

            $this->render( "edit", array( "model" => $model, "users"=>$userItems, "relations"=>$relations ) );
        }
            else $this->actionIndex();
    }
};