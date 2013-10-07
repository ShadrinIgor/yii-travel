<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 04.11.12
 * Time: 2:29
 * To change this template use File | Settings | File Templates.
 */
class BannerInit extends CApplicationComponent
{
    var $position;
    var $category;

    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.banners.models.*");
    }

    public function getBannerByCategory( $category )
    {
        $banner = false;
        $DBParams = DBQueryParamsClass::CreateParams()
                        ->setConditions( "category=:category" )
                        ->setParams( array( ":category"=>$category ))
                        ->setOrderBy( "count_show DESC" )
                        ->setLimit( 1 );

        $bannerArray = BBaners::fetchAll( $DBParams );

        if( sizeof( $bannerArray ) > 0)
        {
            $banner = $bannerArray[0];
            // Окончание показа банера
            if( $banner->id >0 && ( !empty( $banner->finish_date) && strtotime( $banner->finish_date ) < time() ) )
            {
                $banner =false;
                $banner->update( array( "count_show"=>$banner->count_show+1 ) );

                // Отправляем уведомление о окончании заказщику
                if( $banner->email )
                {
    /*                $subject = "Показ рекламного банера на сайте ".ZONA_HOST." успешно завершен";
                    $message = "Здравствуйте<br/>
                                Показ рекламного банера на сайте ".ZONA_HOST." успешно завершен.<br/>
                                Параметры:<br/>
                                -------------------------------------------------<br/>\
                                Дата начала: ".date( "d.m.Y", strtotime( $start_date ) )."<br/>
                                Дата окнчания: ".date( "d.m.Y", strtotime( $finish_date ) )."<br/>
                                Количество показов: ".( $count_show + $addCount )."<br/>
                                <br/>
                                С уважением<br/>
                                Администрация сайта ".ZONA_HOST;

                    mailto( $subject."-", $from='', $email, $message );  */
                }
            }
        }

        // Дефолтовый банер
        if( !$banner )
        {
            $DBParams = DBQueryParamsClass::CreateParams()
                ->setConditions( "category=:category AND `default`=1" )
                ->setParams( array( ":category"=>$category ))
                ->setOrderBy( "count_show DESC" )
                ->setLimit( 1 );

            $bannerArray = BBaners::fetchAll( $DBParams );
            if( sizeof( $bannerArray ) > 0)$banner = $bannerArray[0];
        }

        if( !empty( $banner ) )
        {
            $controller = new Controller("index");
            $controller->layout = false;
            $controller->render( "ext.banners.views.index", array( "banner"=>$banner ) );
        }
    }
}
