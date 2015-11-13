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
        // Yii::import("ext.banners.models.*");
    }

    public function getBannerByCategory( $categoryKeyWord )
    {
        if( !empty( $categoryKeyWord ) )
        {
            $banner = false;

            $categoryModel = ExBannerPosition::fetchByKeyWord( $categoryKeyWord );
            if( !$categoryModel || $categoryModel->id >0 )
            {
                $DBParams = DBQueryParamsClass::CreateParams()
                                ->setConditions( "position_id=:category AND status_id=2 " )
                                ->setParams( array( ":category"=>$categoryModel->id ))
                                ->setOrderBy( "date_finish ASC" )
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
                            ->setConditions( "position_id=:category AND `default`=1 AND status_id=2" )
                            ->setParams( array( ":category"=>$categoryModel->id ))
                            ->setOrderBy( "count_show DESC" )
                            ->setCache(0)
                            ->setLimit( 1 );

                        $bannerArray = ExBanner::fetchAll( $DBParams );
                        if( sizeof( $bannerArray ) > 0)$banner = $bannerArray[0];
                    }

                    if( $banner->id >0 ) // У величиваем счетчик просмотра
                    {
                        $banner->update( array( "count_show"=>$banner->count_show+1, "date_finish"=>time() ) );

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
    }
}
