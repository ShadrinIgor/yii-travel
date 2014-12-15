<?php

class UploadClearProavtoCommand extends CConsoleCommand
{
    public function run($args)
    {
        mysql_connect( "localhost", "world_news_admin", "7TVzoANC" );
        mysql_select_db( "yii_travel_db" );
        mysql_query( "DELETE FROM catalog_upload WHERE ste='proavto.uz' ORDER BY id LIMIT 20" ) or die( mysql_error() );

        $newCache = CatalogCache::fetchBySlug( "proavto.uz" );
        $newCache->description = "";
        $newCache->date = 1;
        if( !$newCache->save() )
            print_r( $newCache->getErrors() );

        $newCache2 = CatalogCache::fetchBySlug( "proavto_uz_page" );
        $newCache2->description = 1;
        $newCache2->date = 1;
        if( !$newCache2->save() )
            print_r( $newCache2->getErrors() );
    }
}