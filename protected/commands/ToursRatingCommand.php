<?php

class ToursRatingCommand extends CConsoleCommand
{
    public function run($args)
    {
        // Расчет ретинга фирмы
        /*
                + Заполленность описания 40
                    если не заполнено - 30

                + Заполленность ПРОГРАММЫ 40
                    если не заполнено - 30

                + Заполленность ЦЕНЫ 80
                    если не заполнено - 30

                + Заполенность ЦЕНЫ И ВАЛЮТЫ 100
                    - если не заполнена цена - 100
                    не учитывать если не заполнено валюта

                + Заполенность ВКЛЮЧННО 40
                    если не заполнено - 30

                + Заполенность НЕ ВКЛЮЧННО 20
                + Заполенность ВНИМАНИЕ 20
                + Заполенность ДЛИТЕЛЬНОСТЬ 40
                    если не заполнено - 30

                + Галлерея + 10 за каждую, но учитывать только 5
                    Если нет не одной то -50
                    Если меньше 3 то -20

         */

        $count = 100;
        $lastFirm = CatCache::fetchBySlug("index_last_tours");
        if( $lastFirm->date != date("Y-m-d") )
        {
            $lastFirm->value=0;
        }

        $list = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id>:id")->setParams( array( ":id"=>$lastFirm->value ) )->setLimit( $count ) );
        foreach( $list as $item )
        {
            $id = $item->id;
            $rating = 0;

            // Проверяем описание
            if( (int)$item->price >0 )
            {
                $rating += 100;
                if ($item->currency_id->id > 0)
                {
                    $rating += 50;
                }
            }
                else $rating -=50;

            if( $item->description )
            {
                if( strlen( trim( strip_tags( $item->description ) ) ) >200 )
                    $rating += 100;
            }
                else $rating -= 30;

            if( $item->program )
            {
                if( strlen( trim( strip_tags( $item->program ) ) ) >200 )
                    $rating += 40;
            }
            //else $rating -= 30;
            if( $item->prices )
            {
                if( strlen( trim( strip_tags( $item->prices ) ) ) >100 )
                    $rating += 40;
            }
            //else $rating -= 30;

            if( $item->included )
            {
                if( strlen( trim( strip_tags( $item->included ) ) ) >100 )
                    $rating += 40;
            }
            //else $rating -= 30;

            if( $item->duration )$rating += 40;
            //else $rating -= 30;

            if( $item->not_included )$rating += 20;

            if( $item->attention )$rating += 20;

            // Галлерея
            $images = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_tours' AND item_id=:id")->setParams( array( ":id"=>$id ) ) );
            if( $images > 0 )
            {
                if( sizeof( $images )>3 )
                {
                    if( sizeof( $images )>5 )$rating += 80;
                                        else $rating += sizeof( $images ) * 10;
                }
                    else $rating -= 30;
            }

            $item->rating =  $rating;
            if( !$item->save() )print_r( $item->getErrors() );

            if( $item->id > 0 )
            {
                $lastFirm->value = $item->id;
                $lastFirm->date = date( "Y-m-d", mktime( date("h")+1,0,0,date("m"),date("d"), date("Y") ) );
                //echo $lastFirm->date."*".mktime( date("h")+1,0,0,date("m"),date("d"), date("Y") );
                if (!$lastFirm->save()) print_r($lastFirm->getErrors());
            }
        }
    }
}