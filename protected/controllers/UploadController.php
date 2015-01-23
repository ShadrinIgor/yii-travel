<?php

class UploadController extends Controller
{
    public function actionIndex()
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        //  Ташкент
        $url = "http://pogoda.yandex.ru/tashkent/";
        $countNewNews = $this->getCategoryNews( $url, 19, "http://news.mail.ru", "Ташкент", 1 );
            /*print_r( $matches );
            return;*/


            return $countNewNews;
    }

    public function getCategoryNews( $url, $cid, $site, $city, $cityId )
    {
        $result = file_get_contents( $url );
        //$result = str_replace( "'", "&#039;", $result );
        $ar = explode( 'forecast-brief forecast-item', $result );
        $ar = explode( 'tabs-panes__pane', $ar[1] );

        $arrayDays = array( "пн", "вт", "ср", "чт", "пт", "сб", "вс" );
        $activeDay = 0;
        $matches = array();
        $ar = explode( '<li', $ar[0] );

        for( $i=1;$i<sizeof($ar);$i++ )
        {
            $newMatches = array();
            $ar2 = explode( 'forecast-brief__item-dayname', $ar[$i] );
            $ar2 = explode( 'forecast-brief__item-day', $ar2[1] );
            $newMatches[0] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $ar2 = explode( 'forecast-brief__item-description', $ar2[1] );
            $newMatches[1] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $ar2 = explode( 'forecast-brief__item-temp-day', $ar2[1] );
            $newMatches[2] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $ar2 = explode( 'forecast-brief__item-temp-night', $ar2[1] );
            $newMatches[3] = trim( strip_tags( '<span class="'.$ar2[0] ) );

            $newMatches[4] = trim( strip_tags( '<span class="'.$ar2[1] ) );

            $matches[] = $newMatches;
        }

        print_r( $matches );
        die;

        /*
       for( $i=1;$i<sizeof($ar);$i++ )
       {
           if( $i==1 ) // Даты
           {
               $ar2 = explode( "</span>", $ar[$i] );
               for( $n=1;$n<sizeof( $ar2 )-1;$n++ )
               {
                   $ar3 = explode( '<span>', $ar2[$n] );
                   $day_ = strip_tags( $ar3[0] );
                   $ar3 = explode( '&nbsp;', $ar3[1] );

                   $m = date( "m" );
                   $year = date( "Y" );
                   $day = $ar3[0]*1;
                   if( $day<$activeDay )
                   {
                       if( $m<12 )$m += 1;
                           else
                       {
                           $m = 1;
                           $year +=1;
                       }
                   }

                   $date = $year."-".$m."-".$day;
                   if( $n==1 )$day_ .= $arrayDays[ date("w")-1 ];
                   $matches[ 0 ][ $n-1 ] = array( $date, $day_ );

                   $activeDay = $day;
               }
           }

                       if( $i==2 ) // картинка
                       {
                           $ar2 = explode( '</td>', $ar[$i] );
                           for( $n=0;$n<sizeof( $ar2 )-1;$n++ )
                           {
                               $ar3 = explode( '" /></i>', $ar2[$n] );
                               $ar4 = explode( '/', $ar3[0] );
                               $matches[ 1 ][ $n ][0] = trim( strip_tags( $ar3[ 1 ] ) );
                               $matches[ 1 ][ $n ][1] = trim( strip_tags( $ar4[ sizeof( $ar4 )-1 ] ) );
                           }
                       }

                       if( $i==3 ) // погода днем
                       {
                           $ar[$i] = "<td ".$ar[$i];
                           $ar2 = explode( '</td>', $ar[$i] );
                           for( $n=0;$n<sizeof( $ar2 )-1;$n++ )
                           {
                               $matches[ 2 ][ $n ] = trim( strip_tags( $ar2[ $n ] ) );
                           }
                       }

                       if( $i==4 ) // погода ночью
                       {
                           $ar[$i] = "<td ".$ar[$i];
                           $ar2 = explode( '</td>', $ar[$i] );
                           for( $n=0;$n<sizeof( $ar2 )-1;$n++ )
                           {
                               $matches[ 3 ][ $n ] = trim( strip_tags( $ar2[ $n ] ) );
                           }
                       }
                   }

                   print_r( $matches );
                   die;

                   if( sizeof( $matches[0] )>0 && $cityId )
                   {
                       mysql_query( "DELETE FROM catalog_weather WHERE city='".$cityId."'" );
                   }

                   for( $i=0;$i<sizeof( $matches[0] );$i++ )  //sizeof( $matches )
                   {
                       if( $matches[0][$i][0] )
                       {
                           list( $exists ) = mysql_fetch_array( mysql_query( "SELECT id FROM catalog_weather WHERE `date`='".$matches[0][$i][0]."' AND name='".$city."' AND del=0" ) );
                           if( !$exists  )
                           {
                               $query = "INSERT INTO catalog_weather( city, `date`, name, day_, image, w_day, w_nigth, w_status, cid, id_lang, path )
                               VALUES( '".$cityId."', '".$matches[0][$i][0]."', '".$city."', '".$matches[0][$i][1]."', '".$matches[1][$i][1]."', '".$matches[2][$i]."', '".$matches[3][$i]."', '".$matches[1][$i][0]."', '231', 1, ':231:' )";
                               echo $query."<br/>";
                               $res = mysql_query( $query ) or die( mysql_error() );
                               $newId = mysql_insert_id();

                               $query2 = "UPDATE catalog_weather SET lang_group='".$newId."'".(  $matches[$i]["image"] ? ", image = '".$newImage."'" : "" )." WHERE id='".$newId."'";
                               mysql_query( $query2 ) or die( mysql_error() );
                           }
                           else
                           {
                               $query = "UPDATE catalog_weather SET `city`='".$cityId."', `date`='".$matches[0][$i][0]."', name='".$city."', day_='".$matches[0][$i][1]."', image='".$matches[1][$i][1]."', w_day='".$matches[2][$i]."', w_nigth='".$matches[3][$i]."', w_status='".$matches[1][$i][0]."' WHERE id='".$exists. "'" ;
                               echo $query."<br/>";
                               $res = mysql_query( $query ) or die( mysql_error() );
                           }
                       }
                   }
           */
    }
}
