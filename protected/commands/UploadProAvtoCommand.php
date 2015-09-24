<?php

class UploadProAvtoCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "*";
        $link = "http://proavto.uz";
        $listPages = array();

        $newCache = CatalogCache::fetchBySlug( "proavto.uz" );
        if( !$newCache->description )
        {
            echo "*";
            $newCache1 = CatalogCache::fetchBySlug( "proavto_uz_page" );
            if( $newCache1->description == 1 )$text = file_get_contents( "http://proavto.uz/ru/ads/search?sortby=datenew&pageSize=10" );
            else $text = file_get_contents( "http://proavto.uz/ru/ads/search?sortby=datenew&pageSize=10&page=".$newCache1->description );

            $arr = explode( 'class="foot"', $text );

            $arr = explode( 'class="adcell"', $arr[0] );
            for( $i=1;$i<sizeof( $arr )-1;$i++ )
            {
                $arr1 = explode( 'class="add_wish', $arr[$i] );
                $arr1 = explode( 'href="', $arr1[0] );
                $arr1 = explode( '"', $arr1[1] );
                $listPages[] = trim( $link.$arr1[0] );
            }

            $newCache->description = serialize( $listPages );
            $newCache->date = time();
            if( !$newCache->save() )
                print_r( $newCache->getErrors() );

            print_r( $listPages );
        }
        else $listPages = unserialize( $newCache->description );
die("&");
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
                    $arrE = explode( "mailto:", $text );
                    $arrE = explode( '"', $arrE[1] );
                    $email = trim( $arrE[0] );

                    $arrE = explode( "@", $email );
                    $name = $arrE[0];

                    echo "##".$email."-".$name;//.;
                    $chechEmail = CatalogUsersSubscribe::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "email='".$email."'" )->setCache(0) );
                    if( sizeof( $chechEmail ) == 0 )
                    {
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
                $newPage->site = "proavto.uz";
                if( !$newPage->save() )
                    print_r( $newPage->getErrors() );
            }
        }


        // Если не нашол не одной новой стринцы то скидываем кеш, и устанавливаем текущей следующую страницу
        if( $countPage==0 )
        {
            $newCache = CatalogCache::fetchBySlug( "proavto.uz" );
            $newCache->description = "";
            $newCache->date = 0;
            $newCache->save();

            $newCache1 = CatalogCache::fetchBySlug( "proavto_uz_page" );
            $newCache1->description = (int)$newCache1->description>0 ? (int)$newCache1->description + 1 : $newCache1->description=2;
            $newCache1->date = 0;

            if( !$newCache1->save() )
                $newCache1->getErrors();

        }

    }
}