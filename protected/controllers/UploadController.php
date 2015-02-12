<?php

class UploadController extends Controller
{
    public function actionIndex()
    {
        $catalog = new CatalogWheters();
        $catalog->deleteAll();

        //  Ташкент
        $url = "http://pogoda.yandex.ru/tashkent/";
        $countNewNews = $this->getCategoryNews( $url, 1 );

        //  Самарканд
        $url = "https://pogoda.yandex.ru/samarkand";

        //  Бухара
        $countNewNews = $this->getCategoryNews( $url, 3 );
        $url = "https://pogoda.yandex.ru/bukhara";
        $countNewNews = $this->getCategoryNews( $url, 2 );

        //  Термез
        $url = "https://pogoda.yandex.ru/termez";
        $countNewNews = $this->getCategoryNews( $url, 4 );

        //  Фергана
        $url = "https://pogoda.yandex.ru/phergana";
        $countNewNews = $this->getCategoryNews( $url, 6 );

        //  Хива
        $url = "https://pogoda.yandex.ru/khiva";
        $countNewNews = $this->getCategoryNews( $url, 7 );

        //  Шахрисабзе
        $url = "https://pogoda.yandex.ru/shahrisabz";
        $countNewNews = $this->getCategoryNews( $url, 8 );


    }

    public function getCategoryNews( $url, $cityId )
    {
        $result = file_get_contents( $url );
        $ar = explode( 'forecast-brief forecast-item', $result );

        // Сегодняшний день
        $newMatches = array();
        $ar2 = explode( '"current-weather"', $ar[0] );
        $ar2 = explode( 'current-weather__comment', $ar2[1] );
        $newMatches[1] = "Сейчас";

        $ar2 = explode( 'current-weather__thermometer_type_now">', $ar2[1] );
        $newMatches[2] = trim( strip_tags( '<span class="'.$ar2[0] ) );

        $ar2 = explode( 'current-weather__col_type_after', $ar2[1] );
        $ar3 = explode( '&thinsp;', $ar2[0] );
        $newMatches[3] = $ar3[0];

        $ar2 = explode( 'current-weather__info', $ar2[2] );
        $ar2 = explode( 'weather__thermometer_type_after', $ar2[0] );
        $newMatches[4] = trim( strip_tags( '<span class="'.$ar2[1] ) );
        $newMatches[5] = $this->getImage( $newMatches[2] );
        $new = new CatalogWheters();
        $new->city_id = $cityId;
        $new->name = $newMatches[1];
        $new->title = $newMatches[2];
        $new->image = $newMatches[5];
        $new->value1 = $newMatches[3];
        $new->value2 = $newMatches[4];
        $new->save();

        $ar = explode( 'tabs-panes__pane', $ar[1] );

        $arrayDays = array( "вс", "пн", "вт", "ср", "чт", "пт", "сб" );
        $ar = explode( '<li', $ar[0] );

        for( $i=1;$i<sizeof($ar);$i++ )
        {
            $newMatches = array();
            $ar2 = explode( 'forecast-brief__item-dayname', $ar[$i] );
            $ar2 = explode( 'forecast-brief__item-day', $ar2[1] );
            $newMatches[0] = trim( strip_tags( '<span class="'.$ar2[0] ) );
            if( $newMatches[0] == "сегодня" )$newMatches[0] = $arrayDays[ date("w") ];

            $ar2 = explode( 'forecast-brief__item-description', $ar2[1] );
            $newMatches[1] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $ar2 = explode( 'forecast-brief__item-temp-day', $ar2[1] );
            $newMatches[2] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $ar2 = explode( 'forecast-brief__item-temp-night', $ar2[1] );
            $newMatches[3] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $newMatches[4] = trim( strip_tags( '<span class="'.$ar2[1] ) );

            $newMatches[5] = $this->getImage( $newMatches[2] );

            $new = new CatalogWheters();
            $new->city_id = $cityId;
            $new->name = $newMatches[1];
            $new->title = $newMatches[2];
            $new->image = $newMatches[5];
            $new->value1 = $newMatches[3];
            $new->value2 = $newMatches[4];
            $new->save();
        }
    }

    function getImage( $input )
    {
        switch( $input )
        {
            case "облачно, временами снег" : $out = "13.png";break;
            case "облачно" : $out = "5.png";break;
            case "облачно с прояснениями" : $out = "6.png";break;
            case "переменная облачность" : $out = "6.png";break;
            case "малооблачно" : $out = "5.png";break;
            case "облачно, небольшой дождь" : $out = "11.png";break;
            case "переменная облачность, небольшой дождь" : $out = "15.png";break;
            case "облачно с прояснениями, небольшой дождь" : $out = "15.png";break;
            case "облачно, небольшой дождь со снегом" : $out = "13.png";break;
            case "облачно, снег" : $out = "13.png";break;
            case "переменная облачность, небольшой снег" : $out = "12.png";break;

            case "облачно, небольшой снег" : $out = "13.png";break;
            case "облачно с прояснениями, небольшой снег" : $out = "12.png";break;
            case "ясно" : $out = "7.png";break;
            default : $out = "";
        }

        return $out;
    }
}
