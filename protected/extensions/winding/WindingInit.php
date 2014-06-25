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

    public function get_web_page( $url, $uagent, $returnTransfer = 1, $referer = "" )
    {
        $ch = curl_init( $url );

        /*
            //Адрес прокси с портом
            $proxy='proxyserver.domain.local:8080';

            //Пользователь
            $user="VasilevPS";

            //Пароль прокси
            $pass="mypass";

            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $user.":".$pass)
         */

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $returnTransfer);   // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
        curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
        curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
        if( !empty( $referer ) )curl_setopt($ch, CURLOPT_REFERER, $referer );
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа

        if( $returnTransfer == 1 )$content = curl_exec( $ch );
        else $content = "";
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }

    public function userVisit()
    {
        /*
        1. # Имитировать разные операционные системы и параметры
        2. Имитировать хождению по сайту на одном проксе 2-3 страницы, в зависимости от настроек
            // . Надо сделать ввиде настройки список разделов по которым накоторые Впользователь будет захадоить первой
            . необходимо сделать время мехду заходами ( от 30 до 40 секунд ) - прийдется делать ввиде ссесии в базе
            . использовать расписание заходом на каждый час
            . сделать ввиде процента долю страниниц с прямым заходом без рефера

        -- 3. Имитировать переход ( первое открытие ) с внешний источником ( соцсети и поисковики по ключевым словам )
            . Для поисковиком, необходимо будет указать какое количество ключ. слов необходимо использовать

           4. сделать паралельные запроссы
        */

        $windingModel = ExWinding::fetch( 1 );

        /* ----  Входящий параметры  ---- */
        $pageCountMin = 1;
        $pageCountMax = $windingModel->pageCountMax;
        $pageUrl = $windingModel->url;
        $listStartPage = explode( ";", $windingModel->listStartPage );
        $listAgents = ExWindingUseragents::fetchAll();

        /* ---- Определеяем параметры для пользователя ---- */
        $userPageCount = rand( $pageCountMin, $pageCountMax );
        $userStartPageNum = rand( 0, sizeof( $listStartPage ) - 1 );
        $userAgent = rand( 0, sizeof( $listAgents ) );

        echo "Start from ".$listStartPage[ $userStartPageNum ]." | userPageCount = ".$listAgents[ $userAgent ]."<br/>";
        $result = $this->get_web_page( $listStartPage[ $userStartPageNum ], $listAgents[ $userAgent ], 1 );
        if (($result['errno'] != 0 )||($result['http_code'] != 200))
        {
            echo $result['errmsg'];
        }
        else
        {
//            echo $result['content']."*";
            preg_match_all( "|<a href=\"".$pageUrl."([^\"]*)\"|", $result['content'], $forLink, PREG_PATTERN_ORDER );
            $userListLinks = $forLink[1];
            shuffle( $userListLinks );
        }

        //print_r( $userListLinks );
        //die;

        // Имитируем переходы по внутренним страницам сайта
        $referLink = $listStartPage[ $userStartPageNum ];
        if( $userPageCount >1 && sizeof( $userListLinks ) >0 )
        {
            for( $i=0;$i<$userPageCount-1;$i++ )
            {
                $linkNum = rand( 0, sizeof( $userListLinks )-1 );
                $link = $pageUrl.$userListLinks[ $linkNum ];
                echo "Inner page ".$link."<br/>";
                $result = $this->get_web_page( $link, $listAgents[ $userAgent ], 0, $referLink );
                if (($result['errno'] != 0 )||($result['http_code'] != 200))
                {
                    echo $result['errmsg'];
                }
                else
                {
                    echo "Inner page<br/>";
                }

                $referLink = $link;
                shuffle( $userListLinks );
            }
        }
    }

/*    public function getBannerByCategory( $categoryKeyWord )
    {
        if( !empty( $categoryKeyWord ) )
        {
            $banner = false;

            $categoryModel = ExBannerCategory::fetchByKeyWord( $categoryKeyWord );
            if( !$categoryModel || $categoryModel->id >0 )
            {
                $DBParams = DBQueryParamsClass::CreateParams()
                                ->setConditions( "category=:category AND status_id=2 AND " )
                                ->setParams( array( ":category"=>$categoryModel->id ))
                                ->setOrderBy( "last_date ASC" )
                                ->setCache(0)
                                ->setLimit( 1 );

                $bannerArray = ExBanner::fetchAll( $DBParams );

                if( sizeof( $bannerArray ) > 0)
                {
                    $banner = $bannerArray[0];

                    // Дефолтовый банер
                    if( !$banner )
                    {
                        $DBParams = DBQueryParamsClass::CreateParams()
                            ->setConditions( "category=:category AND `default`=1 AND status_id=2" )
                            ->setParams( array( ":category"=>$categoryModel->id ))
                            ->setOrderBy( "count_show DESC" )
                            ->setCache(0)
                            ->setLimit( 1 );

                        $bannerArray = ExBanner::fetchAll( $DBParams );
                        if( sizeof( $bannerArray ) > 0)$banner = $bannerArray[0];
                    }

                    if( $banner->id >0 ) // У величиваем счетчик просмотра
                    {
                        $banner->update( array( "count_show"=>$banner->count_show+1, "last_date"=>time() ) );

                        // Если выставлено ограничение показов
                        if( $banner->finish_count_show >0 && $banner->count_show>=$banner->finish_count_show )
                        {
                            $banner->update( array( "status_id"=>3 ) );
                        }

                        // Окончание показа банера, если указана дата окончания публикации
                        //echo "=".$banner->finish_date."  ".( date("d.m.Y", $banner->finish_date ) )."<hr/>";
                        //echo "=".time()." ".( date("d.m.Y" ));
                        if( !empty( $banner->finish_date ) && $banner->finish_date <= time() )
                        {
                            // $banner->update( array( "status_id"=>3 ) );

                            // Отправляем уведомление о окончании заказщику
                            if( $banner->email )
                            {

                            }
                        }
                    }
                }



                if( !empty( $banner ) )
                {
                    $controller = new Controller("index");
                    $controller->layout = false;
                    return $controller->renderPartial( "ext.banners.views.index", array( "banner"=>$banner ), true );
                }
            }
                else throw new CHttpException("Banner error", "Неправельно указана категория банера ( ".$categoryKeyWord." )");
        }
            else throw new CHttpException("Banner error", "Не указана категория банера");

        return false;

    }*/
}
