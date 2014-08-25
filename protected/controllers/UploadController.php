<?php

class UploadController extends Controller
{
    public function actionIndex()
    {
        $link = "http://torg.com";
        $listPages = array();
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

        print_r( $listPages );

        for( $i=0;$i<5;$i++ )
        {
            $text = file_get_contents( $listPages[$i] );
            $arr = explode( "details", $text );
            echo $arr[2];
            die;
            $arr = explode( "</table>", $arr[3] );
            if( strpos( $arr[0], "mailto" ) !== false )
            {
                $arrE = explode( "mailto", $arr[0] );
                $arrE = explode( '"', $arrE[0] );
                $email = $arrE[0];

                $arrN = explode( "</tr>", $arr[0] );
                $arrN = explode( "<td", $arrN[1] );
                $name = strip_tags( ">".$arrN[3] );
                echo $email."-".$name;//."##";
            }
                else echo "UPS";
        }
        //print_r( $listPages );
    }
}