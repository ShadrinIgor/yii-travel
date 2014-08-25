<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 04.11.12
 * Time: 2:29
 * To change this template use File | Settings | File Templates.
 */
class WindingInit extends CApplicationComponent
{
    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.winding.models.*");
    }

    public function updateListProxi()
    {
        $arr = array();
        $file = fopen( "http://proxyhub.ru/proxies/txt/?type%5B%5D=HTTP&type%5B%5D=HTTPS&type%5B%5D=SOCKS4&type%5B%5D=SOCKS5&anon%5B%5D=HIA&anon%5B%5D=ANM&anon%5B%5D=NOA&ports=&sort_by=trust&sort_order=desc&per_page=50&uniq_ip=on&code=4d641bf99b4d23b708b2ba5d3b73d3a7", "r" );
        while( $line = fgets( $file ) )
        {
            $arr[]= $line;
        }

        $count = count($arr);
        if( $count >0 )
        {
            $all = new ExWindingProxi();
            $all->deleteAll();
            for ($i = 0; $i < $count; $i++)
            {
                $value = htmlspecialchars($arr[$i]);
                $new = new ExWindingProxi();
                $new->name = $value;
                if( !$new->save() )
                {
                    print_r( $new );
                    print_r( $new->getErrors() );
                }
            }
        }

        $cache = ExWindingCache::fetchBySlug( "update_proxy" );
        $cache->description = date("H:i d.m.Y");
        if( !$cache->save() )
            print_r( $cache->getErrors() );
    }

    public function get_web_page( $url, $uagent, $proxy, $id, $returnTransfer = 1, $referer = "" )
    {
        // Проверяем файл куков
        $baseUrl = dirname(dirname(dirname(dirname(__FILE__))))."/httpdocs";
        $cookie = $baseUrl."/curl_cookie/curl_cookie_".$id.".txt";

        $PHPSESSID = "";
        if( !file_exists( $cookie ) )
        {
            fclose(fopen($cookie,'x'));
            chmod( $cookie, 0777 );
        }
            /*else
        {
            $ftext = file_get_contents( $cookie );
//            echo "\nftext: ".$ftext."\n";
            if( !empty( $ftext ) )
            {
                $farr = explode( "PHPSESSID", $ftext );
//                print_r( $farr );
//                echo "==".trim( $farr[1] )."==";
                $PHPSESSID = trim( $farr[1] );
            }
        }*/

        //устанавливаем прокси
        $ch = curl_init( );
//        $dopUrl = "";
//        if( !empty( $proxy ) )curl_setopt($ch, CURLOPT_PROXY, $proxy);
        if( !empty( $proxy ) )
        {
            if( strpos($proxy, ":")!== false )$ip = substr( $proxy, 0, strpos($proxy, ":") );
                                         else $ip = $proxy;

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            if( !empty( $ip ) )$dopUrl = "?ip=".$ip;
        }
            else $dopUrl = "";
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $user.":".$pass);

        echo "Load page: ".$url.$dopUrl."<br/>";

        curl_setopt($ch, CURLOPT_URL,$url.$dopUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false );   // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_HEADER, true );           // не возвращает заголовки
        curl_setopt($ch, CURLOPT_NOBODY, true);           // Установите эту опцию в ненулевое значение, если вы не хотите, чтобы тело/body включалось в вывод.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
        curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300); // таймаут соединения
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);         // таймаут ответа
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа

        curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie );
        //if( !empty( $PHPSESSID ) )curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=".$PHPSESSID );
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie );
        if( !empty( $referer ) )curl_setopt($ch, CURLOPT_REFERER, $referer );

        $content = curl_exec( $ch );

        //print_r(curl_getinfo($ch, CURLINFO_HEADER_OUT));
        //echo "<hr/><br/>";

        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );

        curl_close( $ch );
        //echo "content :".$content;

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;

        return $header;
    }

    public function addStat( $isInner = false )
    {
        // Определяем количество отправок по расписанию на этот час
        $hour = date("G")+2;
        if( $hour>24 )$hour = $hour-24;

        $hourModel = ExWindingTimetable::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "name=:hour" )->setParams( array( ":hour"=>$hour ) ) );
        if( sizeof($hourModel)>0 )$hourModelID = $hourModel[0]->id;
                             else $hourModelID = 0;

        $check = ExWindingStat::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "date=:date AND timetable_id=:timetable_id" )->setParams( array( ":date"=>date("Y-m-d"), ":timetable_id"=>$hourModelID ) )->setCache(0) );
        ## echo sizeof( $check );
        if( sizeof( $check ) >0 )
        {
            if( !$isInner )$check[0]->count_items++;
                      else $check[0]->count_items_inner++;
            $check[0]->save();
        }
            else
        {
            $newStat = new ExWindingStat();
            $newStat->name = "-";
            $newStat->winding_id = 1;
            $newStat->timetable_id = $hourModelID;
            $newStat->count_items = 1;
            $newStat->date = date( "Y-m-d" );
            if( !$newStat->save() )
                    print_r( $newStat->getErrors() );
        }

    }

    public function checkSession()
    {
        $windingModel = ExWinding::fetch( 1 );
        $pageListLinks = array();
        $listSession = ExWindingSession::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(3)->setCache(0) );
        foreach( $listSession as $session )
        {
            $needReturn = sizeof( $pageListLinks ) == 0 ? 1 : 0;
            // echo "Start from ".$session->name." | userPageCount = ".$session->need_count." | userAgent = ".$session->useragents_id->name." | proxy = ".$session->proxi."<br/>";
            $result = $this->get_web_page( trim( $session->name ), $session->useragents_id->name, $session->proxi, $session->visit_id, $needReturn, $session->referal );
//          $result = $this->get_web_page( $pageUrl.$pageVisit, $listAgents[ $userAgent ]->name, $userProxiName, $visitID, $needUpdateCache == true ? 1 : 0, $pageReferal );
            if (($result['errno'] != 0 ))//||($result['http_code'] != 200)
            {
                //print_r( $result );
                echo "Error: ".$result['errmsg']."<hr/>";
            }
                else
            {
                echo "ok ( ".$result['errmsg']." )<br/>";
                $this->addStat( true );
                if( sizeof( $pageListLinks ) == 0 )
                {
##                    preg_match_all( "|<a href=\"".$windingModel->url."([^\"]*)\"|", $result['content'], $forLink, PREG_PATTERN_ORDER );
##                    $pageListLinks = $forLink[1];
                    //print_r( $pageListLinks );

                }

                // Создаем сессию для имитации брожения по сайту через какой-то промежуток времени
                if( $session->need_count >1 )
                {
                    if( sizeof( $pageListLinks )>0 )
                    {
                        $newLinkNum = rand( 0, sizeof( $pageListLinks )-1 );
                        $newPageVisit = trim( $windingModel->url ).trim( $pageListLinks[ $newLinkNum ] );
                    }
                        else $newPageVisit = trim( $windingModel->url );

                    $this->createSession( $windingModel, $session->useragents_id->id, $session->need_count-1, $session->name, $newPageVisit, $windingModel->url, $session->proxi, $session->visit_id );
                }
                    else
                {
                    // Удаляем куки для этого визита
                    $id = $session->visit_id;
                    $cookie = "curl_cookie/curl_cookie_".$id.".txt";
//                    echo "delete file: ".$cookie."<br/>";
                    unlink( $cookie );
                }

                // Удаялем старую сессию
                $session->delete();
            }
        }
    }

    public function userVisit()
    {
        /*
        1. # Имитировать разные операционные системы и параметры
        2. Имитировать хождению по сайту на одном проксе 2-3 страницы, в зависимости от настроек
            // . Надо сделать ввиде настройки список разделов по которым накоторые Впользователь будет захадоить первой
            //. необходимо сделать время мехду заходами ( от 30 до 40 секунд ) - прийдется делать ввиде ссесии в базе
            //. использовать расписание заходом на каждый час
            . сделать ввиде процента долю страниниц с прямым заходом без рефера

        -- 3. Имитировать переход ( первое открытие ) с внешний источником ( соцсети и поисковики по ключевым словам )
            . Для поисковиком, необходимо будет указать какое количество ключ. слов необходимо использовать

        !- 4. сделать паралельные запроссы
        */

        /*
             Определеяем график отправок в этот час
             Запускать будем каждые 10 минут, поэтому делим на 6 эту сумму и определяем колическо отправлемых за раз M
             1-й запуск - Отправлем сначала M страниц стартовых, если необходимо добавляем в сессию
             2-й запуск - Проверяем сессии, удаляем все сесси, и если есть надо добавлем опять сессию, затем опять отправляем M записей
         */

        $windingModel = ExWinding::fetch( 1 );

        /* ----  Входящий параметры  ---- */
        $pageCountMin = 1;
        $pageCountMax = $windingModel->pageCountMax;
        $pageUrl = trim( $windingModel->url );
        $listStartPage = explode( ";", $windingModel->listStartPage );
        $listAgents = ExWindingUseragents::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1) );
        $listProxi = ExWindingProxi::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1) );

        $pageReferal = $this->getReferal( $windingModel->listReferalPage, $windingModel->directСalls );

        // Определяем количество отправок по расписанию на этот час
        $hour = date("H")+2;
        if( $hour>24 )$hour = $hour-24;

        $hourModel = ExWindingTimetable::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "name=:hour" )->setParams( array( ":hour"=>$hour ) ) );
        $hourCountItem = $hourModel[0]->count_item; // Общее количетво на этот час
        $stepCountItem = round( $hourCountItem/20 ); // Количество отправок за один шаг

        // Проверяем кеш ссылок
        $cacheModel = ExWindingCache::fetchBySlug( "list_links" );
        $needUpdateCache = false;
        $listStartPage = array_merge( $listStartPage, explode( ";", $cacheModel->description ) );
//        if( !$cacheModel->description || $cacheModel->nexttime<time() ) // Если кеш ссылок пуст или устарел обновляем его
//            $needUpdateCache = true;

        $pageListLinks = array();

        /* ---- Определеяем параметры для пользователя ---- */
        $userStartPageNum = rand( 0, sizeof( $listStartPage ) - 1 );
//        print_r( $listStartPage );
        $pageVisit = trim( $listStartPage[ $userStartPageNum ] );

        //$stepCountItem=1;
        for( $i=0;$i<$stepCountItem;$i++ )
        {
            // Устанавливаем ID сесси
            $visitID = rand(100, 9999).time();

            // Определяем наугад агент пользователя
            $userAgent = rand( 0, sizeof( $listAgents )-1 );

            // Определяем наугад прокси сервер
            $userProxi = rand( 0, sizeof( $listProxi )-1 );
            if( !empty( $userProxi ) )$userProxiName = $listProxi[ $userProxi ]->name;
                                 else $userProxiName = "";

            // Определяем количество переходм для пользователя
            $userPageCount = rand( $pageCountMin, $pageCountMax ); // ".$listAgents[ $userAgent ]->name."
//            echo "Start from ".$pageUrl.$pageVisit." userPageCount = ".$userPageCount." | userAgent =  ".$listAgents[ $userAgent ]->name." | proxi = ".$userProxiName." | referal = ".$pageReferal." | needUpdateCache = ".$needUpdateCache."<br/>";
            $result = $this->get_web_page( $pageUrl.$pageVisit, $listAgents[ $userAgent ]->name, $userProxiName, $visitID, $needUpdateCache == true ? 1 : 0, $pageReferal );
            if (($result['errno'] != 0 ))//||($result['http_code'] != 200)
            {
                echo "Error: #".$result['errno']." ".$result['errmsg']."<hr/>";
                //print_r( $result );
                $cookie = "curl_cookie/curl_cookie_".$visitID.".txt";
##                echo "delete file: ".$cookie."<br/>";
                unlink( $cookie );
            }
                else
            {
                echo "ok ( ".$result['errno']." ".$result['errmsg']." )<br/>";
                $this->addStat();
                //## echo $result['content'];
                if( $needUpdateCache )
                {
                    preg_match_all( "|<a href=\"".$pageUrl."([^\"]*)\"|", $result['content'], $forLink, PREG_PATTERN_ORDER );
                    $pageListLinks = $forLink[1];
                    $listPageLinks = implode( ";", $pageListLinks );
                    if( sizeof( $pageListLinks ) >0 )
                    {
                        $cacheModel->description = $listPageLinks;
                        $cacheModel->nexttime = time() + 60*60;
                        if( !$cacheModel->save() )
                            print_r( $cacheModel->getErrors() );

                        $listStartPage = array_merge( explode( ";", $windingModel->listStartPage ), $pageListLinks );
                    }
                }


                // Создаем сессию для имитации брожения по сайту через какой-то промежуток времени
                if( $userPageCount >1 )
                {
                    $newLinkNum = rand( 0, sizeof( $listStartPage )-1 );
                    $newPageVisit = $pageUrl.trim( $listStartPage[ $newLinkNum ] );
                    $this->createSession( $windingModel, $listAgents[ $userAgent ]->id, $userPageCount-1, $pageUrl.$pageVisit, trim( $newPageVisit ), trim( $pageUrl ), $userProxiName, $visitID );
                }
                    else
                {
                   // Удаляем куки для этого визита
                    $cookie = "curl_cookie/curl_cookie_".$visitID.".txt";
//                    echo "delete file: ".$cookie."<br/>";
                    unlink( $cookie );
                }
            }

            // Определем ссылку для следующего перехода
            if( sizeof( $pageListLinks ) > 0 )
            {
                shuffle( $pageListLinks );
                $newLinkNum = rand( 0, sizeof( $pageListLinks )-1 );
                $pageVisit = $pageUrl.$pageListLinks[ $newLinkNum ];
            }
                else
            {
                $userStartPageNum = rand( 0, sizeof( $listStartPage ) - 1 );
                $pageVisit = $listStartPage[ $userStartPageNum ];
            }
        }
    }

    private function getReferal( $listReferalPage, $procent )
    {
        $referal = "";
        if( $procent >0 )
        {
            $n = rand( 1, 100 );
            if( $n<=$procent )
            {
                $list = explode( ";", $listReferalPage );
                $newNum = rand( 0, sizeof( $list ) - 1 );
                $referal = $list[ $newNum ];
            }
        }

        return $referal;
    }

    private function createSession( $windingModel, $useragents_id, $userPageCount, $referal, $newPageVisit, $pageUrl, $proxy, $visitId )
    {
        $newSession = new ExWindingSession();
        $newSession->winding_id = $windingModel->id;
        $newSession->name = $newPageVisit;
        $newSession->proxi = $proxy;
        $newSession->useragents_id = $useragents_id;
        $newSession->date = time();
        $newSession->date_next = $windingModel->id;
        $newSession->need_count = $userPageCount;
        $newSession->referal = $referal;
        $newSession->visit_id = $visitId;
        if( !$newSession->save() )
            print_r( $newSession->getErrors() );
    }

}
