<?php

class AutoNotifier
{

    static function onRegistration( CCModel $user )
    {
        if( $user->id >0 && $user->active == 0 )
        {
            $subject = "Вы зарегистрировались на сайте World-Travel.uz но не подтвердили Ваш Email";
            $message = "<h2>Вы зарегистрировались на сайте World-Travel.uz но не подтвердили Ваш Email</h2><p>Прошло уже много времени но вы так и не подтвердили свой Email, возможно у Вас возникли какие-то проблемы напишите в нашу службу поддержки, и она обязательно Вам поможет.<br/>Email службы технической поддержки: support@world-travel.uz</p>";
            $message .= "<h3 style=\"background-color: #6C0000;color: #fff;padding: 5px;text-align: center\">Для чего нужна регистрация?</h3><p>После прохождения неслобной регистрации и подтверждения Email для Вас будет доступны все сервисы нашего сайта( и заметьте все бесплатно ) </p>";
            $res = SubscribesUzHelper::sendEmail( $user->name, $user->email, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">".$message."<br/></div>", 2, 1 );
        }
    }

    static function onRegistrationConfirm( CCModel $user )
    {
        if( $user->id >0 && $user->active == 1 )
        {
            $countFirms = CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions( "user_id=:uid" )->setParams( array( ":uid"=>$user->id ) ) );
            if( $countFirms==0 )
            {
                $subject = "Вы зарегестировались на сайте World-Travel.uz, но не добавили свою фирму и её услуги";
                $message = "<h2>Вы зарегстировались на сайте World-Travel.uz, но не добавили свою фирму и её услуги</h2><p>Вы успешно зарегистрировались и подтвердили свой Email но так и не добавили не одной фирмы, тура , услуги. Почему?<br/> Возможно у Вас возникли какие-то проблемы напишите в нашу службу потдержки и она обязательно Вам поможет.<br/>Email служба технической поддержки: support@world-travel.uz</p>";
                $message .= "<h3 style=\"background-color: #6C0000;color: #fff;padding: 5px;text-align: center\">Что доступно Вам после регистрации?</h3><p>";
                $message .= "<ul><li>Размещение своей фирмы с контактами</li><li>Размещение туров Вашей компании</li><li>Размещение рекламных акций</li><li>Размещение услуг компании</li><li>Размещение БЕСПЛАТНОГО рекламного баннера*</li></ul></p>";
                $res = SubscribesUzHelper::sendEmail($user->name, $user->email, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">" . $message . "<br/></div>", 2, 1);
            }
        }
    }

    static function onAddFirmsService( $eventArray )
    {
        if( empty( $eventArray["event"] ) )return;

        $item = $eventArray["event"]->sender;
        $params = $eventArray["params"];

        if( $item->id >0 )
        {
            $itemParam = array();
            $itemParam["recomFields"] = array( "name", "description" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 5;
            $itemParam["item_count"] = 5;
            if( $params["status"] == "reminder" )$itemParam["check_visible"] = true;

            $reccomen = self::objectCheck( $item, $itemParam );
            $reccomenAdd = "";
            // Если нет рекомендации то написать что они могут добавить тур акцию и т.д.
            if( empty( $reccomen ) || strlen( $reccomen )<200 )
            {
                $countTours = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$item->id ) ) );
                $countFirmService = CatalogFirmsService::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$item->firm_id->id ) ) );
                $countFirmBanners = CatalogFirmsBanners::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$item->firm_id->id ) ) );

                $reccomenAdd = "<br/><h2 style='text-align: center'>Обязательно добавте другие услуги Вашей компании</h2>";
                $reccomenAdd .= "<ul>";
                if( $countTours == 0 )$reccomenAdd .= "<li>Добавляем ТУРЫ фирмы</li>";
                if( $countFirmService == 0 )$reccomenAdd .= "<li>Добавляем \"ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ\" компании</li>";
                if( $countFirmBanners == 0 )$reccomenAdd .= "<li>Добавляем \"БЕСПЛАТНЫЙ БАННЕР\" компании</li>";
                $reccomenAdd .=     "<li>Добавляем \"БЕСЛАТНЫЙ БАННЕР\"</li>
                                </ul>
                                <br/>
                                <a href=\"".SiteHelper::createUrl("/site/addFirm")."\">Инструкция: \"Как правильно добавить фирму на сайт\".</a>";
            }

            if( empty( $params["status"] ) )
            {
                $subject = !empty( $reccomen ) ? "Ваша услуга - ".$item->name." успешно сохранена, но ..." : "Ваша услуга - ".$item->name." успешно сохранена" ;
                $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Ваша акция - <b>".$item->name."</b> успешно сохранена</h2>";
                $message .= !empty( $reccomen ) ? "Ваша услуга - <b>".$item->name."</b> успешно сохранена, но мы советуем Вам сделать её описание интерестнее. " : "Поздравляем Ваша услуга - <b>".$item->name."</b> успешно сохранена" ;
            }
                else
            {
                if( $params["status"] == "reminder" )
                {
                    $subject = "Ваша услуга - " . $item->name . " не самая лучшая";
                    $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Ваша услуга - <b>".$item->name."</b> не самая лучшая</h2>";
                }
            }

            $message .= "<br/>Для редактирования услуги, необходимо перейти в раздел МОИ ФИРМЫ > ".$item->firm_id->name." > ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ.";
            if( !empty( $reccomen ) )$message .= "<br/><br/>Мы проверили введенные Вам данные и подготовили для Вас рекомендации по улучшению акции.".$reccomen;
            if( !empty( $reccomenAdd ) )$message .= "<br/>".$reccomenAdd;

            if( empty( $params["status"] ) || !empty( $reccomen ) || !empty( $reccomenAdd ) )
                $res = SubscribesUzHelper::sendEmail( $item->firm_id->user_id->name, $item->firm_id->user_id->email, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">".$message."<br/></div>", 2, 1 );
        }
    }

    static function onAddFirmsItems( $eventArray )
    {
        if( empty( $eventArray["event"] ) )return;

        $item = $eventArray["event"]->sender;
        $params = $eventArray["params"];

        if( $item->id >0 )
        {
            $itemParam = array();
            $itemParam["recomFields"] = array( "date2", "date", "sale" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 5;
            $itemParam["item_count"] = 5;
            if( $params["status"] == "reminder" )$itemParam["check_visible"] = true;

            $reccomen = self::objectCheck( $item, $itemParam );
            $reccomenAdd = "";
            // Если нет рекомендации то написать что они могут добавить тур акцию и т.д.
            if( empty( $reccomen ) || strlen( $reccomen )<200 )
            {
                $countTours = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$item->id ) ) );
                $countFirmItems = CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$item->firm_id->id ) ) );
                $countFirmBanners = CatalogFirmsBanners::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$item->firm_id->id ) ) );

                $reccomenAdd = "<br/><h2 style='text-align: center'>Обязательно добавте другие услуги Вашей компании</h2>";
                $reccomenAdd .= "<ul>";
                if( $countTours == 0 )$reccomenAdd .= "<li>Добавляем ТУРЫ фирмы</li>";
                if( $countFirmItems == 0 )$reccomenAdd .= "<li>Добавляем \"АКЦИИ\" и \"СКИДКИ\" компании</li>";
                if( $countFirmBanners == 0 )$reccomenAdd .= "<li>Добавляем \"БЕСПЛАТНЫЙ БАННЕР\" компании</li>";
                $reccomenAdd .=     "<li>Добавляем \"БЕСЛАТНЫЙ БАННЕР\"</li>
                                </ul>
                                <br/>
                                <a href=\"".SiteHelper::createUrl("/site/addFirm")."\">Инструкция: \"Как правильно добавить фирму на сайт\".</a>";
            }

            if( empty( $params["status"] ) )
            {
                $subject = !empty( $reccomen ) ? "Ваша акция - ".$item->name." успешно сохранена, но ..." : "Ваша акция - ".$item->name." успешно сохранена" ;
                $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Ваша акция - <b>".$item->name."</b> успешно сохранена</h2>";
                $message .= !empty( $reccomen ) ? "Ваша услуга - <b>".$item->name."</b> успешно сохранена, но мы советуем Вам сделать её описание интерестнее. " : "Поздравляем Ваша акция - <b>".$item->name."</b> успешно сохранена" ;
            }
                else
            {
                if( $params["status"] == "reminder" )
                {
                    $subject = "Вашу акцию - " . $item->name . " нужно сделать привликательнее";
                    $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Напоминаем Вашу акцию - <b>".$item->name."</b> нужно сделать привлекательнее</h2>";
                }
            }

            $message .= "<br/>Для редактирования акции, необходимо перейти в раздел МОИ ФИРМЫ > ".$item->firm_id->name." > АКЦИИ И СКИДКИ.";
            if( !empty( $reccomen ) )$message .= "<br/><br/>Мы проверили введенные Вам данные и подготовили для Вас рекомендации по улучшению акции.".$reccomen;
            if( !empty( $reccomenAdd ) )$message .= "<br/>".$reccomenAdd;





            if( empty( $params["status"] ) || !empty( $reccomen ) || !empty( $reccomenAdd ) )
                $res = SubscribesUzHelper::sendEmail( $item->firm_id->user_id->name, $item->firm_id->user_id->email, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">".$message."<br/></div>", 2, 1 );
        }
    }

    static function onAddTour( $eventArray )
    {
        if( empty( $eventArray["event"] ) )return;

        $tour = $eventArray["event"]->sender;
        $params = $eventArray["params"];

        if( $tour->id >0 )
        {

            $itemParam = array();
            $itemParam["recomFields"] = array( "price", "prices", "not_included", "attention", "cancellation" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 5;
            $itemParam["item_count"] = 5;
            if( !empty( $params["status"] ) && $params["status"] == "reminder" )$itemParam["check_visible"] = true;

            $reccomen = self::objectCheck( $tour, $itemParam );
            $reccomenAdd = "";
            // Если нет рекомендации то написать что они могут добавить тур акцию и т.д.
            if( empty( $reccomen ) || strlen( $reccomen )<200 )
            {
                $countFirmItems = CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$tour->firm_id->id ) ) );
                $countFirmService = CatalogFirmsService::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$tour->firm_id->id ) ) );
                $countFirmBanners = CatalogFirmsBanners::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$tour->firm_id->id ) ) );

                $reccomenAdd = "<br/><h2 style='text-align: center'>Обязательно добавте другие услуги Вашей компании</h2>";
                $reccomenAdd .= "<ul>";
                if( $countFirmItems == 0 )$reccomenAdd .= "<li>Добавляем \"АКЦИИ\" и \"СКИДКИ\" компании</li>";
                if( $countFirmService == 0 )$reccomenAdd .= "<li>Добавляем \"ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ\" компании</li>";
                if( $countFirmBanners == 0 )$reccomenAdd .= "<li>Добавляем \"БЕСПЛАТНЫЙ БАННЕР\" компании</li>";
                $reccomenAdd .=     "<li>Добавляем \"БЕСЛАТНЫЙ БАННЕР\"</li>
                                </ul>
                                <br/>
                                <a href=\"".SiteHelper::createUrl("/site/addFirm")."\">Инструкция: \"Как правильно добавить фирму на сайт\".</a>";
            }

            $firmUrl = SiteHelper::createUrl("/travelAgency/description");

            if( empty( $params["status"] ) )
            {
                $subject = !empty( $reccomen ) ? "Ваш тур - ".$tour->name." успешно сохранен, но ..." : "Ваш тур - ".$tour->name." успешно сохранен" ;
                $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Ваш тур - <b>".$tour->name."</b> успешно сохранен</h2>";
                $message .= !empty( $reccomen ) ? "Ваша тур - <b>".$tour->name."</b> успешно сохранен, но мы советуем Вам сделать его описание интерестнее. " : "Поздравляем Ваш тур - <b>".$tour->name."</b> успешно сохранен" ;
            }
                else
            {
                if( $params["status"] == "reminder" )
                {
                    $subject = "Ваш тур - " . $tour->name . " нуждается в доработке";
                    $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Напоминаем что Ваш тур - <b>" . $tour->name . "</b> успешно сохранен</h2>";
                }
            }

            $message .= "<br/>Для редактирования тура, необходимо перейти в раздел МОИ ФИРМЫ > ".$tour->firm_id->name." > ТУРЫ КОМПАНИИ.";
            if( !empty( $reccomen ) )$message .= "<br/><br/>Мы проверили введенные Вам данные и подготовили для Вас рекомендации по улучшению тура.".$reccomen;
            if( !empty( $reccomenAdd ) )$message .= "<br/>".$reccomenAdd;

            if( empty( $params["status"] ) || !empty( $reccomen ) || !empty( $reccomenAdd ) )
                $res = SubscribesUzHelper::sendEmail( $tour->firm_id->user_id->name, $tour->firm_id->user_id->email, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">".$message."<br/></div>", 2, 1 );
        }
    }

    static function onAddFirm( $eventArray )
    {
        if( empty( $eventArray["event"] ) )return;

        $firm = $eventArray["event"]->sender;
        $params = $eventArray["params"];

        if( $firm->id >0 )
        {
            /*
                    Типы рекомендаций:
                      - по заполнению
                      -  - заполненные поля
                      -  - по объему заполненности полей
                      - -  Обязательно по цене`
                      -  - наличие картинок

                      -  добавьте также туры для других стран ( а вы знали что самым популярным местом для туризма в Малайзию )
             */
            $itemParam = array();
            $itemParam["recomFields"] = array( "name", "description" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 0;
            if( !empty($params["status"]) && $params["status"] == "reminder" )$itemParam["check_visible"] = true;

            $reccomen = self::objectCheck( $firm, $itemParam );
            $reccomenAdd = "";
            // Если нет рекомендации то написать что они могут добавить тур акцию и т.д.
            if( empty( $reccomen ) || strlen( $reccomen )<200 )
            {
                $countTours = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$firm->id ) ) );
                $countFirmItems = CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$firm->id ) ) );
                $countFirmService = CatalogFirmsService::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$firm->id ) ) );
                $countFirmBanners = CatalogFirmsBanners::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array( ":fid"=>$firm->id ) ) );

                $reccomenAdd = "<br/><h2 style='text-align: center'>Вы можете добавить услуги Вашей компании</h2>";
                $reccomenAdd .= "<ul>";
                if( $countTours == 0 )$reccomenAdd .= "<li>Добавляем ТУРЫ фирмы</li>";
                if( $countFirmItems == 0 )$reccomenAdd .= "<li>Добавляем \"АКЦИИ\" и \"СКИДКИ\" компании</li>";
                if( $countFirmService == 0 )$reccomenAdd .= "<li>Добавляем \"ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ\" компании</li>";
                if( $countFirmBanners == 0 )$reccomenAdd .= "<li>Добавляем \"БЕСПЛАТНЫЙ БАННЕР\" компании</li>";
                $reccomenAdd .=     "
                                </ul>
                                <br/>
                                <a href=\"".SiteHelper::createUrl("/site/addFirm")."\">Инструкция: \"Как правильно добавить фирму на сайт\".</a>";
            }

            if( empty( $params["status"] ) )
            {
                $subject = !empty( $reccomen ) ?  "Ваша фирма - ".$firm->name." успешно сохранена, но ..." : "Поздравляем Ваша фирма - ".$firm->name." успешно сохранена" ;
                $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Ваша фирма - <b>".$firm->name."</b> успешно сохранена</h2>";
                $message .= !empty( $reccomen ) ? "Ваша фирма - <b>".$firm->name."</b> успешно сохранена, но мы советуем Вам сделать ее описание лучше. " : "Поздравляем Ваша фирма - <b>".$firm->name."</b> успешно сохранена" ;
            }
                else
            {
                if( $params["status"] == "reminder" )
                {
                    $subject = "Объявление Вашей фирмы - " . $firm->name . " можно сделать лучше";
                    $message = "<h2 style=\"margin: 5px 0px 15px 0px;text-align: center\">Напоминаем, что объявление Вашей фирмы - " . $firm->name . " можно сделать лучше</h2>";
                }
            }

            $message .= "<br/>Для редактирования описания фирмы, необходимо перейти в раздел <a href=\"".SiteHelper::createUrl("/user/firms")."\">Мои фирмы</a>.";
            if( !empty( $reccomen ) )$message .= "<br/><br/>Мы проверили введенные Вам данные и подготовили для Вас рекомендации по улучшению Вашей фирмы.".$reccomen;
            if( !empty( $reccomenAdd ) )$message .= "<br/>".$reccomenAdd;

            // Если это напоминание и нет рекомендаци то ничего не отправляем
            if( empty( $params["status"] ) || !empty( $reccomen ) || !empty( $reccomenAdd ) )
            {
                $res = SubscribesUzHelper::sendEmail($firm->user_id->name, $firm->user_id->email, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">" . $message . "<br/></div>", 2, 1);
            }
        }
    }

    static function objectCheck( CCModel $objectModel, array $param )
    {
        /*
            $itemParam["recomFields"] = array( "name", "description", "country_id", "image", "email", "www", "tel", "address" );
            $itemParam["recomSizeFields"] = array( "description"=>500 );
            $itemParam["image_count"] = 0;
         */

        $cout = "";
        $attributeLabels = $objectModel->attributeLabels();
        $attributePlaceholder = $objectModel->attributePlaceholder();

        // Проверяем опубликовано ли объявление
        if( !empty( $param["check_visible"] ) && $param["check_visible"] == true && $objectModel->active == 0 )
        {
            $cout .= "<br/><h3 style='background-color: #6C0000;color: #fff;padding: 5px;text-align: center'>Вам нравится терять клиентов?</h3><p>Пользователи не видят Ваше объявление, так как вы его еще не опубликовали.<br/><b>Чего же Вы ждете?</b><br/>Переходите не странциу редактирование, проверьте еще раз все ли впорядке в описаниии Вашего объявления и нажимайте на кнопку [ Опубликовать на сайте? ].<br/></p><h4>Ваши клиенты ждут Вас!!!</h4>";
        }

        // Определяем рекоменадции по
        if( sizeof( $param["recomFields"] ) >0 )
        {
            $recommendation = "";
            foreach( $param["recomFields"] as $field )
            {
                if( !$objectModel->$field )
                    if( !empty( $attributeLabels[ $field ] ) )$recommendation .= "<li><b>".$attributeLabels[ $field ]."</b>".( !empty( $attributePlaceholder[$field] ) ? ".<br/>".$attributePlaceholder[$field] : "" )."</li>";
                                                                      else $recommendation .= "<li>".$field."</li>";
            }

            if( !empty( $recommendation ) )
            {
                $cout .= "<br/><h3 style=\"background-color: #6C0000;color: #fff;padding: 5px;text-align: center\">Привлеките больше внимания клентов </h3><p>Для привлечения максимального количества клентов мы советуем Вам заполнить следующие поля: <ul>".$recommendation."</ul> <br/> <b>Внимание!!!</b>Данные именно этих полей анализируются, для того чтобы определить позицию объявления в поиске. И соответсвенно чем качественнее Вы заполните указанные поля, тем лучшую позицию сможет занять Ваше объявление. </p>";
            }
        }

        //  Проверяем размероность полей
        if( sizeof( $param["recomSizeFields"] ) >0 )
        {
            $recommendationSize = "";
            foreach( $param["recomSizeFields"] as $field=>$value )
            {
                $fieldValue = trim( strip_tags( $objectModel->$field ) );
                if( $objectModel->$field && strlen($fieldValue ) < $param["recomSizeFields"][$field] )
                {
                    $fieldName = !empty( $attributeLabels[ $field ] ) ? $attributeLabels[ $field ] : $field;
                    $recommendationSize .= "<li>Для поля \"<b>" . $fieldName . "</b>\" мы рекомендуем размер - ".$param["recomSizeFields"][$field]." знаков, а Вы указали только ".strlen($fieldValue )." знаков.</li>";
                }
            }
            if( !empty( $recommendationSize ) )
            {
                $cout .= "<br/><h3 style=\"background-color: #6C0000;color: #fff;padding: 5px;text-align: center\">Заполняйте поля качественно</h3><p>Мы советуем Вам заполнять чественной и удобно читаемой информацией, именно поэтоу мы рекомендуем Вам внести следующие изминения:
<ul>".$recommendationSize."</ul></p>";
            }
        }

        // Если указанны рекомендации по количеству картинок
        if( $param["image_count"] > 0 )
        {

            $count = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("item_id=:fid AND catalog=:catalog")->setParams( array( ":fid"=>$objectModel->id, ":catalog"=>$objectModel->tableName() ) )->setCache(0) );
            if( $count<$param["image_count"] )
            {
                $cout .= "<br/><h3 style=\"background-color: #6C0000;color: #fff;padding: 5px;text-align: center\">Украшайте свое объявление красочными фотографиями</h3>";
                if( $count == 0 )$cout .= "<p>Вы не загрузили не одной фотографии для Вашего объявления - так не пойдет.<br/>
Если Вы действительно хотите привлечь внимание к своему объвлению то Вам необходимо добавить картинки к своему объявлению.<br/>
Мы рекомендуем Вам добавить как минимум:  ".$param["image_count"]." фото</p>";

                if( $count >0 )$cout .= "<p>Вы загрузили всего <b>".$count."</b> фото, а что больше нет?<br/>Чем больше фото вы загрузите тем лехче заинтересовать пользователя в Ваших услугах. Именно поэтому мы рекомендуем минимум ".$param["image_count"]." фото, а максимум 10 фото.</p>";
            }
        }

        // Если указанно рекомендуемое количетсво записей
        if( !empty($param["item_count"]) && $param["item_count"] >0 && empty( $cout ) )
        {
            $objectClass = SiteHelper::getCamelCase( $objectModel->tableName() );
            $countItems = $objectClass::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:fid" )->setParams( array(":fid"=>$objectModel->firm_id->id) ) );
            if( $countItems<$param["item_count"] )
            {
                $cout .= "<br/><h3 style=\"background-color: #6C0000;color: #fff;padding: 5px;text-align: center\">Не останавливайтесь на достигнутом</h3>Вы добавили всего <b>".$countItems."</b> запись(ей), мы же рекомендуем добавить как минимум <b>".$param["item_count"]."</b> запись(ей).<br/>Имейте ввиду чем больше бы добавите услуг компании тем больше получите потенциальных клиентов";
            }
        }

        return $cout;
    }

    static function delInNotificationsQueue( $catalog, $itemId )
    {
        $check = NotificationsQueue::findByAttributes( array( "catalog"=>$catalog, "item_id"=>$itemId ) );
        echo "delete ( ".sizeof( $check )." )";
        if( sizeof( $check ) >0 )
        {
            echo "userID".$check[0]->id;
            $check[0]->delete();
        }
    }

    static function addInNotificationsQueue( $catalog, $itemId, $step = 0 )
    {
        $newdate = time();
        switch( $step )
        {
            case 0 : $newdate = time() + 24*60*60;break;
            case 1 : $newdate = time() + 4*24*60*60;break; // Через 3 дня
            case 2 :
            case 3 :
            case 4 : $newdate = time() + 8*24*60*60;break; // Через 7 дней
            case 5 :
            case 6 :
            case 7 : $newdate = time() + 31*24*60*60;break; // Через 30 дней
        }

        $check = NotificationsQueue::findByAttributes( array( "catalog"=>$catalog, "item_id"=>$itemId ) );
        if( sizeof( $check ) == 0 )
        {
            $new = new NotificationsQueue();
            $new->date = $newdate;
            $new->date2 = date( "Y-m-d", $newdate );
            $new->catalog = $catalog;
            $new->item_id = $itemId;
            $new->step = $step;
            $new->save();
        }
            else
        {
            $check[0]->date = $newdate;
            $check[0]->date2 = date( "Y-m-d", $newdate );
            $check[0]->step = $step;
            if( !$check[0]->save() )
                    print_r( $check[0]->getErrors() );
        }
    }
}