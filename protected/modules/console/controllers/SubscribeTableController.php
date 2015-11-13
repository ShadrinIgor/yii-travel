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
        $del = (int)Yii::app()->request->getParam("del", 0);

        if( $del >0 )
        {
            $item =SubscribeTable::fetch( $del );
            $item->delete();
        }

        if( $action == "recheck" )$this->recheck();

        $list = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "date2, id" )->setLimit(-1)->setCache(0) );
        $this->render( "index", [ "list"=>$list ] );
	}

    public function recheck()
    {
        $indexDay = date("w")+1;
        $countDay = 0;
        $list = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1)->setConditions("active=1")->setOrderBy("id") );
        foreach( $list as $item )
        {
            // Определяем дату
            if( $countDay == 0 )
            {
                if ($indexDay > 4)
                {
                    $countDay += 8 - date("w");
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay, date("Y"));
                }
                else
                {
                    $makeTime = mktime(0, 0, 0, date("m"), date("d") + $countDay + 4 - date("w"), date("Y"));
                    $countDay += 4 - date("w");
                }

                echo $indexDay."<br/>";
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

    public function actionShow( $idIn = 0, $locatIn = "", $return = FALSE )
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        if( $id == 0 && $idIn>0 )$id = $idIn;

        $locat = Yii::app()->request->getParam("location", "");
        if( empty( $locat ) && !empty( $locatIn ) )$locat = $locatIn;

        /*
         График:
             По странам ( сортировка по цене ) 31
             По категориям ( сортировка по цене ) 30
             По странам ( сортировка по просмотрам)
             По категориям ( сортировка по просмотрам )

            Определям кандидата по очереди сначала города потом категории
                Выбираем по сортировке первую страну
                Проверяем по очередньсти

            Формируем письмо
                Заголовок ( зависит от того по стране или категории + от сортировки )
                указываем группу подписциков
                указываем группу рассылоку

            И полетели
         */

        $cout = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Cache-Control" content="public"/>
            <meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate"/>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        </head>
        <body>';

        $logTable = SubscribeTable::fetch( $id );
        if( $logTable->id > 0 )
        {
            if( $locat == "uzb" && $logTable->country_id->id == 1 )return "";

            $countryId = 0;
            $categoryId = 0;
            if( $logTable->country_id->id >0 )
            {
                $countryId = $logTable->country_id->id;
                $countryModel = CatalogCountry::fetch( $countryId );
            }

            if( $logTable->category_id->id >0 )
            {
                $categoryId = $logTable->category_id->id;
                $categoryModel = CatalogToursCategory::fetch( $categoryId );
            }

            if( $countryId >0 || $categoryId>0 )
            {
                $infoParam = "1=1";
                if( $locat == "uzb" )
                {
                    if ($countryId > 0) $infoParam .= " AND country_id='" . $countryId . "'";
                }
                    else $infoParam .= " AND country_id='1'";

                if( $logTable->info_category_id->id >0 )$infoParam .= " AND category_id='".$logTable->info_category_id->id."'";
                $info = CatalogInfo::fetchAll(DBQueryParamsClass::CreateParams()->setConditions( $infoParam )->setLimit(4)->setOrderBy("id DESC")->setCache(0));

                if( $countryId >0 )
                {
                    $toursMinPrice = CatalogTours::fetchAll(DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid AND price>0 AND active=1")->setParams([":cid" => $countryModel->id])->setOrderBy("price")->setLimit(1)->setCache(0));
                    $tours = CatalogTours::fetchAll(DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid AND id !=:id AND active=1")->setParams([":cid" => $countryModel->id, ":id" => $toursMinPrice[0]->id])->setLimit(7)->setOrderBy("rating DESC, price"));
                    $tours[] = $toursMinPrice[0];
                    $subject = $countryModel->title . ", от " . $tours[ sizeof($tours) - 1 ]->price . ($tours[ sizeof($tours) - 1 ]->currency_id->id ? $tours[ sizeof($tours) - 1 ]->currency_id->title : "$");
                }
                    else
                {
                    $params = [":cid" => $categoryModel->id];
                    $condition = "category_id=:cid";
                    if( $locat == "uzb" )
                    {
                        $params = array_merge( $params, [":country"=>1] );
                        $condition .= " AND country_id!=:country";
                    }
                        else
                    {
                        $params = array_merge( $params, [":country"=>1] );
                        $condition .= " AND country_id=:country";
                    }

                    echo $condition."*";
                    $toursMinPrice = CatalogTours::fetchAll(DBQueryParamsClass::CreateParams()->setConditions( $condition )->setParams( $params )->setOrderBy("price")->setLimit(1)->setCache(0));
                    $tours = CatalogTours::fetchAll(DBQueryParamsClass::CreateParams()->setConditions($condition." AND id !=:id")->setParams( array_merge( $params, [":id" => $toursMinPrice[0]->id] ) )->setLimit(7)->setOrderBy("rating DESC, price"));
                    $tours[] = $toursMinPrice[0];

                    if( $locat == "uzb" && $logTable->name )$subject = $logTable->name;
                    if( $locat != "uzb" && $logTable->name_uz )$subject = $logTable->name_uz;

                    if( empty( $subject ) )
                    {
                        if ($tours[ sizeof($tours) - 1 ]->price > 0) $subject = "Тур - " . $categoryModel->name . ", от " . $tours[ sizeof($tours) - 1 ]->price . ($tours[ sizeof($tours) - 1 ]->currency_id->id ? $tours[ sizeof($tours) - 1 ]->currency_id->title : "$");
                                else $subject = "Тур - " . $categoryModel->name;
                    }
                }

                $message = "";

                $message .= "<h1>" . $subject . "</h1><br/>";
                if( $locat == "uzb" && $logTable->image )$message.="<img src=\"".SiteHelper::createUrl("/").$logTable->image."\" style=\"width:599px\" alt=\"".$subject."\" /><br/><br/>";
                if( $locat != "uzb" && $logTable->image_uz )$message.="<img src=\"".SiteHelper::createUrl("/").$logTable->image_uz."\" style=\"width:599px\" alt=\"".$subject."\" /><br/><br/>";



                if( $logTable->description )$message.="<p>".$logTable->description."</p>";
                $message .= "<h3>Предлагаем Вашему вниманию подборку туров с нашего портала <a href=\"http://www.world-travel.uz\">World-Travel.uz</a></h3><br/><table>";
                $n = 0;
                $reserveNum = 0;
                $reserveList = [];
                foreach( $tours as $tour )
                {
                    if( $tour->id == 0 )continue;

                    $image = ImageHelper::getImages( $tour, 1 );

                    // Если картинки для тура нету, то берем её из резерва catalog_image_reserve
                    if( sizeof($image) == 0 )
                    {
                        if( sizeof( $reserveList ) == 0 )$reserveList = CatalogImageReserve::findByAttributes( [ "country_id"=>$tour->country_id->id ] );

                        if( sizeof( $reserveList ) >0  )
                        {
                            $new = new CatGallery();
                            if( !empty( $reserveList[ $reserveNum ] ) )$new->image = $reserveList[ $reserveNum ]->image;
                                else
                            {
                                if( $tour->country_id->banner )$new->image = $tour->country_id->banner;
                                                          else $new->image = $tour->country_id->image;
                            }

                            $image[] = $new;
                            $reserveNum++;
                        }
                    }
                    if( $n==0 || $n==2 || $n==4 || $n==6 )$message .= "<tr>";

                    $message .= "<td style=\"width:50%;text-align:center;vertical-align: top;background-color: #EEE9DD;padding: 10px;border: 1px solid #fff;\">
                            <table width=\"100%\">
                                <tr>
                                    <td style=\"background:#E4DDCD;font-size:13px;text-align: right;padding-right: 5px;vertical-align: middle;\"><b>".$tour->name."</b></td>";

                   if( $tour->price >0 )$message .= "<td style=\"background:#E4DDCD;vertical-align: top;line-height: 14px;text-align: center;\"><span style=\"font-size:10px;\">от</span><br/><b style=\"color:#ff4f00;font-size:24px;\"> ".$tour->price.( $tour->currency_id->id ? $tour->currency_id->title : "$" )."</b><br/></td>";

                   $message .= "</tr>
                            </table>";
                    if( sizeof($image) >0 )$message .= "<div style=\"max-height: 134px;overflow: hidden;\"><img src=\"".( SiteHelper::createUrl("/").ImageHelper::getImage( $image[0]->image, 2 ) )."\" style=\"max-width:200px\"/></div>";
                    //if( $tour->included )$message .= "<td>Включенно: ".$tour->included."</td></tr>";

                    if( $tour->duration )$message .= $tour->duration."<br/>";
                    if( $tour->category_id->id > 0 )$message .= "Тур - ".$tour->category_id->name2."<br/>";
                    $message .= "<div><a style=\"margin-top: 11px;background:#ff4f00;color:#fff;font-weight: bold;display: inline-block;padding: 5px 10px;border-radius: 4px;\" href=\"".SiteHelper::createUrl("/tours/description")."/".$tour->slug.".html\">Заказать</a></div></td>"; //

                    if( $n==1 || $n==3 || $n==5 || $n==7 )$message .= "</tr>";
                    $n++;
                }

                $message .= '</table><br/>';

                if( sizeof($info) >0 )
                {
                    $message .= '<div style="background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;"><table>';

                    foreach ($info as $item) {
                        $message .= "<tr><td colspan=\"2\"><h3 style=\"margin:10px 0px 5px 0px;\">" . $item->name . "</h3></td></tr>
                                     <tr>
                                        <td colspan=\"2\" style=\"border-bottom:1px solid #F4F1EA;padding-bottom:10px;\">
                                            <table width=\"100%\">
                                                <tr>
                                                    <td>";

                        if( $item->image )$message .= "<img src=\"" . SiteHelper::createUrl("/") . ImageHelper::getImage($item->image, 2) . "\" style=\"padding-right: 10px;\" alt=\"" . $item->name . "\" />";

                        $message .= "                </td>
                                                    <td style=\"text-align: justify;vertical-align:top\">" . SiteHelper::getSubTextOnWorld($item->description, 350) . "<br/><div align=\"right\"><a href=\"" . SiteHelper::createUrl("/touristInfo/description")."/". $item->slug . ".html\">читайте подробнее >>></a></div></td>
                                                </tr>
                                            </table>
                                        </td>
                                     </tr>";
                    }

                    $message .= "</table></div>";
                }

                $cout .= $message."</body></html>";
                if( SubscribesUzHelper::sendEmails( array( 51 ), $subject, $message, 3 ) )echo "Ура отправил";
                                                                                        else echo "Что-то пошло не так";
            }
        }

        if( $return ) return $cout;
                 else echo "<div style='width: 800px;margin: 0px auto'>".$cout."</div>";
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

            $this->render( "edit", [ "model" => $model, "users"=>$userItems, "relations"=>$relations ] );
        }
            else $this->actionIndex();
    }
};