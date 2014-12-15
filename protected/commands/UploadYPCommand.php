<?php

class UploadYPCommand extends CConsoleCommand
{
    public function run($args)
    {
        $link = "http://yp.uz/";
        $listPages = array();
        $cacheTopCategory = CatalogCache::fetchBySlug( "yp_uz_top_category" );
        if( $cacheTopCategory->date==0 || $cacheTopCategory->date<= time() )
        {
            $text = file_get_contents( "http://yp.uz/" );
            $arr = explode( "content2", $text );
            $arr = explode( "header", $arr[1] );
            $arr = explode( 'class="chapter"', $arr[0] );

            $listTopCategory = array();
            for( $i=1;$i<sizeof( $arr );$i++ )
            {
                $arr2 = explode( "<div", $arr[$i] );
                $arr2 = explode( 'href="',  $arr2[0] );
                $arr2 = explode( '"',  $arr2[1] );

                $listTopCategory[] = "http://yp.uz".$arr2[0];
            }

            $cacheTopCategory->description = serialize( $listTopCategory );
            $cacheTopCategory->date = time() + 60*60*24*7*4;
            $cacheTopCategory->save();
        }
        else $listTopCategory = unserialize( $cacheTopCategory->description );


        // Вытаскиваем все внутренине категории
        $cacheCategory = CatalogCache::fetchBySlug( "yp_uz_inner_category" );
        if( $cacheCategory->date==0 || $cacheCategory->date<= time() )
        {
            $listSubCategory = array();
            for( $i=0;$i<sizeof( $listTopCategory );$i++ )
            {
                // echo $listTopCategory[$i]."<br/>";
                $text = file_get_contents( $listTopCategory[$i] );
                $arr = explode('border="0px"', $text );
                $arr = explode('class="header"', $arr[1] );
                $arr = explode('href="', $arr[0] );
                for( $n=1;$n<sizeof( $arr );$n++ )
                {
                    $arr2 = explode('"', $arr[$n] );
                    $listSubCategory[] = substr( $link, 0, -1 ).$arr2[0];
                    //echo substr( $link, 0, -1 ).$arr2[0]."<br/>";
                }
            }

            $cacheCategory->description = serialize( $listSubCategory );
            $cacheCategory->date = time() + 60*60*24*7*4;
            $cacheCategory->save();
        }
        else $listSubCategory = unserialize( $cacheCategory->description );

        // Начинаем ходить по категориям и выстаскивать объявления
        $cacheCategory = CatalogCache::fetchBySlug( "yp_uz_current_category" );
        if( $cacheCategory->description )$currentCategory = $listSubCategory[$cacheCategory->description];
        else
        {
            // Сохраняем текщую категорию
            $currentCategory = $listSubCategory[0];
            $cacheCategory->description = 0;
            $cacheCategory->date = time();
            $cacheCategory->save();
        }

        // Определяем текущую страницу данной категории
        $page = CatalogCache::fetchBySlug( "yp_uz_page" );
        if( $page->description >0 )$currentPage = $page->description;

        for( $n=0;$n<30;$n++ )
        {
            if( $currentPage == 1  )$loadPage = $currentCategory;
            else $loadPage = $currentCategory."?page=".$currentPage."&pagesize=10";

            echo $loadPage."<br/>";
            $text = file_get_contents( $loadPage );
            $arr = explode( 'id="ov"', $text );
            $arr = explode( 'class="header2">', $arr[1] );

            echo sizeof( $arr )."*";

            // Значит кончались страницы в этой категории
            if( sizeof( $arr ) == 1 )
            {
                // Скидываем страницу до первой
                $page = CatalogCache::fetchBySlug( "yp_uz_page" );
                $page->description = 1;
                $page->date = time();
                $page->save();

                // Сохраняем новую категорию
                $currentCategory = CatalogCache::fetchBySlug( "yp_uz_current_category" );
                $currentCategory->description = $currentCategory->description + 1;
                $currentCategory->save();

                // Выходим из цикла
                break;
            }

            for( $i=1;$i<sizeof( $arr );$i++ )
            {
                if( strpos( $arr[$i], "Email" ) !== false )
                {
                    $arr2 = explode( '</a>', $arr[$i] );
                    $name = trim( strip_tags( $arr2[0] ) );
                    $arr2 = explode( 'mailto:', $arr2[1] );
                    $arr2 = explode( '"', $arr2[1] );

                    $check = CatalogUsersSubscribe::findByAttributes( array( "email"=>$arr2[0] ) );
                    if( sizeof( $check ) ==0 )
                    {
                        $user = new CatalogUsersSubscribe();
                        $user->name = $name;
                        $user->email = $arr2[0];
                        $user->save();
                    }
                }
            }

            // Сохраняем текущую страницу
            $currentPage++;
            $page->description = $currentPage;
            $page->date = time();
            $page->save();
        }
    }
}