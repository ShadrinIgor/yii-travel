<?php

class UploadController extends Controller
{
    public function actionIndex()
    {
        $link = "http://torg.com";
        $listPages = array();

        $newCache = CatalogCache::fetchBySlug( "torg_uz" );
        if( !$newCache->description )
        {
            $newCache1 = CatalogCache::fetchBySlug( "torg_uz_page" );
            echo $newCache1->description."#";
            if( $newCache1->description == 1 )$text = file_get_contents( "http://www.torg.com/ru/all" );
                                         else $text = file_get_contents( "http://www.torg.com/ru/all/page/".$newCache1->description );

            $arr = explode( "offers blue offers", $text );
            //echo $arr[0]."###";
            //echo $arr[1];
            //die;
            if( empty( $arr[1] ) )
            {
                echo "Oy";
                echo $arr[0];
                die;
            }

            $arr = explode( "/ru/changeview", $arr[1] );
            $arr = explode( "</tr>", $arr[0] );

            for( $i=1;$i<sizeof( $arr )-1;$i++ )
            {
                $arr1 = explode( 'href="', $arr[$i] );
                $arr1 = explode( '"', $arr1[1] );
                $listPages[] = trim( $link.$arr1[0] );
            }

            $newCache->description = serialize( $listPages );
            $newCache->date = time();
            if( !$newCache->save() )
                print_r( $newCache->getErrors() );
        }
            else $listPages = unserialize( $newCache->description );


        $countPage = 0;
        for( $i=0;$i<sizeof( $listPages );$i++ )
        {
            $checkModel = CatalogUpload::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "name='".$listPages[$i]."'" )->setCache(0) );
            if( sizeof( $checkModel ) == 0  )
            {
                $countPage++;
                $text = file_get_contents( $listPages[$i] );
                if( strpos( $text, "mailto" ) !== false )
                {
                    $arr = explode( "Имя:", $text );
                    $arr = explode( "</table>", $arr[1] );
                    $arrE = explode( "mailto:", $arr[0] );
                    $arrE = explode( '"', $arrE[1] );
                    $email = trim( $arrE[0] );

                    $arrN = explode( "</tr>", $arr[0] );
                    $arrN = explode( "<td", $arrN[0] );
                    $name = strip_tags( "<p".$arrN[1] );
                    echo "##".$email."-".$name;//.;
                    $chechEmail = CatalogUsersSubscribe::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "email='".$email."'" )->setCache(0) );
                    if( sizeof( $chechEmail ) == 0 )
                    {
                        echo "N0";//.;
                        $newSubscribe = new CatalogUsersSubscribe();
                        $newSubscribe->name = trim( $name );
                        $newSubscribe->email = trim( $email );
                        if( !$newSubscribe->save() )
                            print_r( $newSubscribe->getErrors() );
                    }
                    //break;
                }

                $newPage = new CatalogUpload();
                $newPage->name = $listPages[$i];
                if( !$newPage->save() )
                    print_r( $newPage->getErrors() );
            }
        }


        // Если не нашол не одной новой стринцы то скидываем кеш, и устанавливаем текущей следующую страницу
        if( $countPage==0 )
        {
            $newCache = CatalogCache::fetchBySlug( "torg_uz" );
            $newCache->description = "";
            $newCache->save();

            $newCache1 = CatalogCache::fetchBySlug( "torg_uz_page" );
            $newCache1->description = (int)$newCache1->description + 1;
            $newCache1->save();
        }
    }
}