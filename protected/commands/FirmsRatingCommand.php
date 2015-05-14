<?php

class FirmsRatingCommand extends CConsoleCommand
{
    public function run($args)
    {
        // Расчет ретинга фирмы
        /*
                * описание
                    * Сайт, Контакты, Адрес, большой текст с описанем
                    * если не описания то - бал
                * галлерея
                    * + бал за каждую картинку
                    * - бал если нет не одной каринки
                * туры
                    * + бал за каждый тур ( если есть рейтинг тура то вмест бала сумируем его если нет то просто 10 )
                    * если нет не одного тура то выставляет бал 0
                * акции
                    * + бал за каждую акцию
                * Коментарии и отзывы
                    * + бал за каждый комментарий
         */

        $count = 30;
        $lastFirm = CatCache::fetchBySlug("index_last_firm");
        if( $lastFirm->date != date("Y-m-d") )
        {
            $lastFirm->value=0;
        }

        $list = CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id>:id")->setParams( array( ":id"=>$lastFirm->value ) )->setLimit( $count )->setOrderBy("id") );
        foreach( $list as $item )
        {
            $id = $item->id;
            $rating = 0;

            // Проверяем описание
            if( $item->www )$rating += 10;
            if( $item->tel && $item->email )$rating += 10;
            if( $item->description )
            {
                $rating += 10;
                if( strlen( $item->description ) > 500 )$rating += 20;
            }
            else $rating -= 10;
    
            if( $item->image )$rating += 10;
            else $rating -= 10;
    
            // end ( Проверяем описание )
    
            // Галлрея
            $images = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_firms' AND item_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $images > 0 )
            {
                $rating += ( $images*5 );
            }
            else $rating -= 10;
    
            // Туры
            $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:id" )->setParams( array( ":id"=>$id ) )->setLimit(-1) );
            foreach( $tours as $tour )
            {
                if( $tour->rating >0 )$rating += $tour->rating;
                else $rating += 10;
            }
    
            if( sizeof( $tours ) == 0 )$rating = 0;
    
    
            // Туры
            $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:id" )->setParams( array( ":id"=>$id ) )->setLimit(-1) );
            foreach( $tours as $tour )
            {
                if( $tour->rating >0 )$rating += $tour->rating;
                else $rating += 10;
            }
    
            if( sizeof( $tours ) == 0 )$rating = 0;
    
            // Акции
            $sales = CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $sales > 0 )
            {
                $rating += ( $sales*5 );
            }
    
            // Коментарии
            $comments = CatalogFirmsComments::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $comments > 0 )
            {
                $rating += ( $comments*5 );
            }

            $item->rating =  $rating;
            if( !$item->save() )print_r( $item->getErrors() );
        }

        if( $item->id > 0 )
        {
            $lastFirm->value = $item->id;
            $lastFirm->date = date( "Y-m-d", mktime( date("h")+1,0,0,date("m"),date("d"), date("Y") ) );
            echo $lastFirm->date."*".mktime( date("h")+1,0,0,date("m"),date("d"), date("Y") );
            if (!$lastFirm->save()) print_r($lastFirm->getErrors());
        }
        echo "*";
    }
}