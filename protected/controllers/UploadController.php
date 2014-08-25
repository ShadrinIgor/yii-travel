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
            $text = file_get_contents( "http://www.torg.com/ru/all" );

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
                $listPages[] = $link.$arr1[0];
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
            $checkModel = CatalogUpload::findByAttributes( array( "name" => $listPages[$i] ), 0 );
            if( sizeof( $checkModel ) == 0  )
            {
                $countPage++;
                $text = file_get_contents( $listPages[$i] );
                $arr = explode( "details", $text );
                $arr = explode( "</table>", $arr[3] );

                if( strpos( $arr[0], "mailto" ) !== false )
                {
                    $arrE = explode( "mailto:", $arr[0] );
                    $arrE = explode( '"', $arrE[1] );
                    $email = $arrE[0];

                    $arrN = explode( "</tr>", $arr[0] );
                    $arrN = explode( "<td", $arrN[1] );
                    $name = strip_tags( "<p".$arrN[2] );

                    $chechEmail = CatalogUsersSubscribe::findByAttributes( array( "email"=>$email ) );
                    if( sizeof( $chechEmail ) == 0 )
                    {
                        echo "##".$email."-".$name;//.;
                        $newSubscribe = new CatalogUsersSubscribe();
                        $newSubscribe->name = trim( $name );
                        $newSubscribe->email = trim( $email );
                        $newSubscribe->save();
                    }
                }

                $newPage = new CatalogUpload();
                $newPage->name = $listPages[$i];
                if( !$newPage->save() )
                    print_r( $newPage->getErrors() );
            }
        }

        fgdfgdf
        // Hfcfgf
        if( $countPage==0 )
    }
}