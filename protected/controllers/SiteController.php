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
         нужно сделать сарипт на WT который будет отправлять рассылку в очередь основываясь на таблице
            - Нужно делать 2 версии для узбекистана и остальные
            - Если в рассылки меньше 4 предложений то не отправлять такое предложение
         */

        $logTable = SubscribeTable::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("date2=:date")->setParams( array( ":date"=>date("Y-m-d") ) )->setLimit(1)->setCache(0) );
        if( sizeof( $logTable ) > 0 )
        {
            Yii::import("modules.console.components.*");
            Yii::import("modules.console.controllers.*");

            $worldCount = 0;
            $uzCount = 0;
            $itemCount = 0;

            $item = $logTable[0];

            $sql = "SELECT count(id) as count_ FROM catalog_tours WHERE active=1";
            if( $item->category_id->id > 0 )$sql .= " AND category_id='".$item->category_id->id."'";

            $worldCountArr = CatalogTours::sql( $sql." AND country_id='1' ");
            if( sizeof( $worldCountArr ) >0 )$worldCount = $worldCountArr[0]["count_"];

            if( $item->country_id->id >1 )
            {
                $uzCountArr = CatalogTours::sql($sql . " AND country_id='" . $item->country_id->id . "'");
                if( sizeof( $uzCountArr ) >0 )$uzCount = $uzCountArr[0]["count_"];
            }
            else
            {
                $uzCountArr = CatalogTours::sql( $sql." AND country_id!=1 " );
                if( sizeof( $uzCountArr ) >0 )$uzCount = $uzCountArr[0]["count_"];
            }

            $class = new SubscribeTableController( rand(100, 999) );
            echo $logTable[0]->id."*";

            // отпраляем рассылку для мира
            if( $worldCount > 4 )
            {
                $message = $class->actionShow( $logTable[0]->id, "", true );
                $usersGroup = SubscribeTableUsers::sql( "SELECT id FROM subscribe_table_users WHERE id in( SELECT rightId FROM cat_relations WHERE leftClass='SubscribeTable' AND leftId='".$logTable[0]->id."' AND rightClass='SubscribeTableUsers' )" );
                foreach( $usersGroup as $key=>$value )
                    $usersGroupsList[] = $value["id"];

                if( !empty( $usersGroupsList ) && sizeof( $usersGroupsList ) >0 )
                {
                    if( SubscribesUzHelper::sendEmails( $usersGroupsList, $logTable[0]->name, $message, 3 ) )echo "Send in World";
                                                                                                        else echo "Have the error, wen send in World";
                }
            }
            echo "<hr/>";
            if( $uzCount > 4 && $logTable[0]->country_id->id != 1 )echo $class->actionShow( $logTable[0]->id, "uzb", true );

//                    echo $message."*";
                    //if( SubscribesUzHelper::sendEmails( array( 7, 35, 41 ), $subject, $message, 3 ) )echo "Ура отправил";
                    //                                                                        else echo "Что-то пошло не так";

        }
            else echo sizeof( $logTable )."*";

        //echo "</body></html>";

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