<?php

class SiteController extends Controller
{

    public function actionIndex()
	{
        $this->layout = '//layouts/main2';
        Yii::app()->page->title = Yii::t("page", "Туристический портал Узбекистана, отдых, туры, туроператоры, путешестви");
        header("cache-control: private, max-age = 86400");
        $this->render('index', [ "controller"=>$this, "content"=>"", "items"=>[] ]);
	}

    public function actionLog( )
    {
        $type = Yii::app()->request->getParam("type", 0);
        $id = (int)Yii::app()->request->getParam("id", 0);
        $action = Yii::app()->request->getParam("action", 0);
        LogHelper::save( $type, $id, $action );
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */

    public function actionSession()
    {
        Yii::app()->winding->checkSession();
    }

    public function actionSession1()
    {
//        print_r( $_SERVER );
        Yii::app()->winding->userVisit();
    }

    public function actionUpdateProxi()
    {
        Yii::app()->winding->updateListProxi();
    }

    public function actionMail()
    {
        $messageUserName = "Игорь";
        $messageUserEmail = "shadrin.igor@gmail.com";
        $messageSubject = "Это первое автоматическое сообщение";
        $messageText = "<h1>Это первое сообщение отправленное через API</h1>Ура получилось";

        echo SubscribesUzHelper::sendEmail( $messageUserName, $messageUserEmail, $messageSubject, $messageText, 0, 1 );
    }

    public function actionTest2()
    {
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

/*echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Cache-Control" content="public"/>
<meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';*/

        $logTable = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("id DESC")->setLimit(1) );
        if( sizeof( $logTable ) == 0 )
        {
            $countryId = CatLogToursCountry::sql( "SELECT country_id FROM cat_log_tours_country GROUP BY country_id ORDER BY `count` DESC LIMIT 1" );

            $log = new SubscribeTable();
            $log->category_id = 0;
            $log->country_id = $countryId;
            $log->date2 = date("Y-m-d");
            $log->sort = 1;
            //if( $log->save() )
            //{
                $countryModel = CatalogCountry::fetch( $countryId );
                if( $countryModel->id >0 )
                {
                    // If status value is 1 - Check ship tour in this country
                    //$toursMinPrice = CatalogTours::sql( "SELECT id FROM catalog_tours WHERE country_id=\"".$countryModel->id."\" ORDER BY price DESC LIMIT 1" );
                    $toursMinPrice = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid AND price>0")->setParams( [ ":cid"=>$countryModel->id])->setOrderBy("price")->setLimit(1)->setCache(0) );
                    $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid AND price>0 AND id !=:id")->setParams( [ ":cid"=>$countryModel->id, ":id"=>$toursMinPrice[0]->id ] )->setLimit( 7 )->setOrderBy("rating DESC, price") );
                    $tours[]=$toursMinPrice[0];
                    $info = CatalogInfo::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid")->setParams( [ ":cid"=>$countryModel->id ] )->setLimit( 4 )->setOrderBy("id DESC") );

                    $subject = $countryModel->title.", от ".$tours[ sizeof($tours )-1 ]->price.( $tours[sizeof($tours )-1]->currency_id->id ? $tours[sizeof($tours )-1]->currency_id->title : "$" );
                    $message = "Предлагаем Вашему вниманию интересную подборку с нашего портала <a href=\"http://www.world-travel.uz\">World-Travel.uz</a>.<br/><br/><h1>".$subject."</h1><br/><table>";
                    $n=0;

                    $reserveNum = 0;
                    $reserveList = [];
                    foreach( $tours as $tour )
                    {
                        $image = ImageHelper::getImages( $tour, 1 );

                        // Если картинки для тура нету, то берем её из резерва catalog_image_reserve
                        if( sizeof($image) == 0 )
                        {
                            if( sizeof( $reserveList ) == 0 )$reserveList = CatalogImageReserve::findByAttributes( [ "country_id"=>$countryModel->id ] );

                            if( sizeof( $reserveList ) >0  )
                            {
                                $new = new CatGallery();
                                $new->image = $reserveList[ $reserveNum ]->image;
                                $image[] = $new;
                                $reserveNum ++;
                            }
                        }
                        if( $n==0 || $n==2 || $n==4 || $n==6 )$message .= "<tr>";

                        $message .= "<td style=\"width:50%;text-align:center;vertical-align: top;background-color: #EEE9DD;padding: 10px;border: 1px solid #fff;\">
                            <table width=\"100%\">
                                <tr>
                                    <td style=\"background:#E4DDCD;font-size:13px;text-align: right;padding-right: 5px;vertical-align: middle;\"><b>".$tour->name."</b></td>
                                     <td style=\"background:#E4DDCD;vertical-align: top;line-height: 14px;text-align: center;\"><span style=\"font-size:10px;\">от</span><br/><b style=\"color:#ff4f00;font-size:24px;\"> ".$tour->price.( $tour->currency_id->id ? $tour->currency_id->title : "$" )."</b><br/>
                                </tr>
                            </table>";
                        if( sizeof($image) >0 )$message .= "<div style=\"max-height: 134px;overflow: hidden;\"><img src=\"".( SiteHelper::createUrl("/").ImageHelper::getImage( $image[0]->image, 2 ) )."\" style=\"max-width:200px\"/></div>";
                        //if( $tour->included )$message .= "<td>Включенно: ".$tour->included."</td></tr>";

                        if( $tour->duration )$message .= $tour->duration."<br/>";
                        if( $tour->category_id->id > 0 )$message .= "Тур - ".$tour->category_id->name2."<br/>";
                        $message .= "<div><a style=\"margin-top: 11px;background:#ff4f00;color:#fff;font-weight: bold;display: inline-block;padding: 5px 10px;border-radius: 4px;\" href=\"".SiteHelper::createUrl("/tours/description")."/".$tour->slug.".html\">Заказать</a></div></td>"; //

                        if( $n==1 || $n==3 || $n==5 || $n==7 )$message .= "</tr>";
                        $n++;
                    }

                    $message .= '</table></div><br/><div style="background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;"><table>';

                    foreach( $info as $item )
                    {
                        $message .= "<tr><td colspan=\"2\"><h3 style=\"margin:10px 0px 5px 0px;\">".$item->name."</h3></td></tr>
                                     <tr>
                                        <td colspan=\"2\" style=\"border-bottom:1px solid #F4F1EA;padding-bottom:10px;\">
                                            <table width=\"100%\">
                                                <tr>
                                                    <td><img src=\"".SiteHelper::createUrl("/").ImageHelper::getImage( $item->image, 2 )."\" style=\"padding-right: 10px;\" alt=\"".$item->name."\" /></td>
                                                    <td style=\"text-align: justify;vertical-align:top\">".SiteHelper::getSubTextOnWorld( $item->description, 350 )."<br/><div align=\"right\"><a href=\"".SiteHelper::createUrl("/touristInfo/description" ).$item->slug.".html\">читайте подробнее >>></a></div></td>
                                                </tr>
                                            </table>
                                        </td>
                                     </tr>";
                        //
                    }

                    $message .= "</table></div>";

//                    echo $message."*";
                    //if( SubscribesUzHelper::sendEmails( array( 7, 35, 41 ), $subject, $message, 3 ) )echo "Ура отправил";
                    //                                                                        else echo "Что-то пошло не так";
                }

            //}
        }
            else
        {

        }

        //echo "</body></html>";

        //$country

    }

    public function actionTest()
    {

        // Расчет ретинга фирмы
        /*
                + Рейтинг фирмы
                    если рейтинг = 0 то - 100

                + Заполленность описания 40
                    если не заполнено - 30

                + Заполленность ПРОГРАММЫ 40
                    если не заполнено - 30

                + Заполленность ЦЕНЫ 40
                    если не заполнено - 30

                + Заполенность ЦЕНЫ И ВАЛЮТЫ 100
                    - если не заполнена цена - 100
                    не учитывать если не заполнено валюта

                + Заполенность ВКЛЮЧННО 40
                    если не заполнено - 30

                + Заполенность НЕ ВКЛЮЧННО 20
                + Заполенность ВНИМАНИЕ 20
                + Заполенность ДЛИТЕЛЬНОСТЬ 40
                    если не заполнено - 30

                + Галлерея + 10 за каждую, но учитывать только 5
                    Если нет не одной то -50
                    Если меньше 3 то -20

         */

        /*        $count = 20;
                $lastFirm = CatCache::fetchBySlug("index_last_tours");
                $list = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id>:id")->setParams( array( ":id"=>$lastFirm->value ) )->setLimit( $count ) );
                foreach( $list as $item )
                {
                    $id = $item->id;
            */
        $id = (int)$_GET["id"];
        $item = CatalogTours::fetch( $id );
        $rating = 0;

        // Рейтинг фирмы
        if( $item->firm_id->rating > 0 )$rating += $item->firm_id->rating;
        elseif( $item->firm_id->rating == 0 )$rating -= 100;

        // Проверяем описание
        if( (int)$item->price >0 )
        {
            if ($item->currency_id->id > 0)
            {
                $rating += 100;
            }
        }
        else $rating -=100;

        if( $item->description )
        {
            if( strlen( trim( strip_tags( $item->description ) ) ) >200 )
                $rating += 40;
        }
        else $rating -= 30;

        if( $item->program )
        {
            if( strlen( trim( strip_tags( $item->program ) ) ) >200 )
                $rating += 40;
        }
        else $rating -= 30;

        if( $item->prices )
        {
            if( strlen( trim( strip_tags( $item->prices ) ) ) >100 )
                $rating += 40;
        }
        else $rating -= 30;

        if( $item->included )
        {
            if( strlen( trim( strip_tags( $item->included ) ) ) >100 )
                $rating += 40;
        }
        else $rating -= 30;

        if( $item->duration )$rating += 40;
        else $rating -= 30;

        if( $item->not_included )$rating += 20;

        if( $item->attention )$rating += 20;

        // Галлерея
        $images = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_tours' AND item_id=:id")->setParams( [ ":id"=>$id ] ) );
        if( $images > 0 )
        {
            $rating += ( $images*5 );
        }
        else $rating -= 10;

        $item->rating =  $rating;
        if( !$item->save() )print_r( $item->getErrors() );

        echo $item->id."-".$rating."<br/>";
    }

    public function actionReloadBanner()
    {
        echo Yii::app()->banners->getBannerByCategory( "top" );
    }

    public function actionPage( $slug = "" )
    {
        if( empty( $slug ) )$page = Yii::app()->request->getParam("page", "");
        else $page = $slug;

        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $page = $key;
            break;
        }

        if( !empty( $page ) )
        {
            $pageInfo = CatalogContent::fetchBySlug( $page );

            if( $pageInfo->id >0 )
            {
                Yii::app()->page->title = $pageInfo->name;
                $this->render('page', [ "content"=>$pageInfo ]);
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            // Проверить урл и выдавать пользователю другие предложение по данному напровлению
            $listValues = ["country", "travelAgency", "tours", "touristInfo", "resorts"  ];
            $ar = explode( "/", $_SERVER["REQUEST_URI"] );

            // Если запрос вот такого вида http://world-travel.uz/thailahjnd_country.html
            if(  sizeof( $ar ) == 0 && strpos( $_SERVER["REQUEST_URI"], "_country" ) !== false )
            {
                $ar = explode( "_country", $_SERVER["REQUEST_URI"] );
            }

            if( empty( $ar[0] ) && !empty(  $ar[1] ) ) $ar[0] = $ar[1];

            $link = "";
            $listItems = [];

            if( sizeof( $ar ) >0 && in_array( $ar[0], $listValues ) )
            {
                $link = $ar[0];

                switch( $link )
                {
                    case "country": $class = "CatalogCountry"; break;
                    case "tours": $class = "CatalogTours"; break;
                    case "touristInfo": $class = "CatalogInfo"; break;
                    case "travelAgency": $class = "CatalogFirms"; break;
                    case "resorts": $class = "CatalogKurorts"; break;
                }

                if( !empty( $class ) )
                    $listItems = $class::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("rating DESC, id DESC")->setLimit(12) );

            }

            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', array_merge( $error, array( "link"=>$link, "list"=>$listItems ) ));
        }
    }

    public function actionGetInfo()
    {
        echo SiteHelper::getAccessInfo();
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers="From: $name <{$model->email}>\r\n".
                    "Reply-To: {$model->email}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }

        $pageInfo = CatalogContent::fetchBySlug( "contact" );
        $this->render('contact',['model'=>$model, "content"=>$pageInfo]);
    }

    public function actionAddFirm()
    {
        $this->render("addFirm");
    }

    public function actionSubscribeOpen()
    {
        $email = Yii::app()->request->getParam("email", "");
        $subscribe = (int)Yii::app()->request->getParam("subscribe", 0);

        if( !empty( $email ) && !empty( $subscribe ) )
        {
            $checkModel = SubscribeSend::findByAttributes( [ "email"=>$email, "item_id"=>$subscribe ] );
            if( sizeof( $checkModel ) >0 && $checkModel[0]->is_open == 0 )
            {
                $checkModel[0]->is_open = 1;
                $checkModel[0]->save();
            }
        }
    }

    public function actionUnSubscribe()
    {
        $email = Yii::app()->request->getParam("email", "");
        $hash = Yii::app()->request->getParam("hash", "");
        $hashCheck = substr( md5( md5( $email ) ), 3, 8 );
        $error = "";

        if( $hash == $hashCheck )
        {
            Yii::import("modules.subscribe.models.*");
            $emailModel = CatalogUsers::findByAttributes( [ "email"=>$email ] );
            if( $emailModel[0]->subscribe == 1 )
            {
                $emailModel[0]->subscribe = 0;
                $emailModel[0]->save();
            }

            $emailModel2 = SubscribeUsers::findByAttributes( [ "email"=>$email ] );
            if( sizeof( $emailModel2 ) )
            {
                $emailModel2[0]->delete();
            }
            $this->render( "unSubscribe" );
        }
        else throw new CHttpException("Ошибка", Yii::t("page", "Неправильный адрес, проверьте адрес").".");
    }
}