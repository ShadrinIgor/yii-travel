<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 31.05.14
 * Time: 19:37
 */

class TranslateHelper
{
    static public function getTranslateModel( $catalog, $id, $language )
    {
        $class = SiteHelper::getCamelCase( $catalog."_".$language );
        if( class_exists( $class ) )
        {
            return $class::fetch( $id );
        }
    }

    static public function getLimitText( $text, $count, $from = 0 )
    {
        $cout = "";
        for( $i=0;$i<$count;$i++ )
        {
            if( $i+$from>= strlen( $text ) ) break;
            $cout .= $text[$i+$from];
        }

        return $cout;
    }

    static public function setTranslate( $model, $transModel, $lang = "en" )
    {
        $name = TranslateHelper::translate( $model->name, $lang );

        if( property_exists( $model, "description" ) )
            if( $model->description )$text = TranslateHelper::translate( $model->description, $lang );
                                else $text = "";

        $text = str_replace( array( "< p", "< div" ), array( "<p", "<div"), $text );

        $requiredFields = $model->getSafeAtributes();
        for( $i=0;$i<sizeof( $requiredFields );$i++ )
        {
            $field = trim( $requiredFields[$i] );
            $transModel->$field = $model->$field;
        }

        $transModel->id = $model->id;
        $transModel->name = $name;
        if( property_exists( $transModel, "location" ) )
            if( $model->location )$transModel->location = TranslateHelper::translate( $model->location, $lang );

        if( property_exists( $transModel, "address" ) )
            if( $model->address )$transModel->address = TranslateHelper::translate( $model->address, $lang );

        if( property_exists( $model, "description" ) )$transModel->description = $text;
        if( !$transModel->save() )
                print_r( $transModel->getErrors() );
            elseif( property_exists( $transModel, "slug" ) )
                SiteHelper::getSlug( $transModel );
    }

    static public function translate( $textIn, $lang = 'en' )
    {
        $step = 0;
        $cout = "";
        for( $n=0;$n<strlen( $textIn );$n+=800 )
        {
            $text = TranslateHelper::getLimitText( $textIn, 600, $n );
            $text = str_replace( array( "\n", "\r" ), "" , $text );

            $file = file_get_contents( "http://translate.google.ru/translate_a/t?client=x&text=".urlencode( $text )."&hl=ru&sl=ru&tl=".$lang."&ie=UTF-8&oe=UTF-8" );

            $res = json_decode( $file );
            if( json_last_error() >0 )
                echo "Error: ".json_last_error()."<br/>";

            $text = "";
            for( $i=0;$i<sizeof( $res->sentences );$i++ )
                $text .= $res->sentences[$i]->trans;

            $text = str_replace( "< /", "</", $text );
            $text = str_replace( "</ ", "</", $text );
            $cout .= $text;
        }

        return $cout;
    }
}