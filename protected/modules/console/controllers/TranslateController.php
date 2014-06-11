<?php

class TranslateController extends ConsoleController
{

    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->page->title = "Перевод";

        if( !empty( $_POST["text"] ) )
        {
            $text = trim( $_POST["text"] );
            $lang = trim( $_POST["lang"] );
            $arr = explode( "\n", $text );
            for( $i=0;$i<sizeof( $arr );$i++ )
            {
                $arr2 = explode( "=>", $arr[ $i ] );
                $arr2[ 1 ] = substr( $arr2[ 1 ], 0, strlen( $arr2[ 1 ] )-2 );
                $value = trim( str_replace( '"', "", $arr2[ 1 ] ) );
                if( !empty( $value ) )
                {
                    $value2 = TranslateHelper::translate( $value, $lang );
                    //echo $value."<br/>";
                    $text = str_replace( '"'.$value.'",', '"'.$value2.'",', $text );
                }
            }
        }
        $this->render( "index", array( "text" => $text ) );
	}

};