<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 04.11.12
 * Time: 2:29
 * To change this template use File | Settings | File Templates.
 */
class AnalysisInit extends CApplicationComponent
{
    /*
     * Инициализация
     */
    public function init( )
    {
        Yii::import("ext.textAnalysis.include.*");
    }

    public function getAnalysis( $text )
    {
        $an = new Stemmer();
        $text = $an->stem_words( $text );

        $text = strip_tags($text); //удаляем html+php
        $text = stripslashes ($text); //удаляем слеши
        $text = mb_strtolower( strip_tags( $text ), "utf-8" );

        $patterns = array (
            '/\  /s',//удаляем двойные пробелы
            '/\       /s',//удаляем табуляторы
        );
        $text = preg_replace($patterns,null,$text); //прогоняем регулярки
        $text = str_replace(array(",",'"','.'), " ",$text); //прогоняем регулярки

        $words = array_unique( explode( ' ', $text ) );  // Оставляем только уникальные значения

// оставляем только слова, которые не меньше 4х букв
        foreach( $words as $key=>$value )
            if( mb_strlen( $value, "utf-8" )<4 )unset( $words[$key] );

        $text .= ' ';

        $result = array();
        foreach( $words as $word ) {
            // исключаем схожие слова, добавляя пробел
            // исключаем слова, вхождениие которых меньше 3х
            if( ( $cnt = substr_count( $text, $word.' ' ) ) < 3 )
                continue;
            $result[ "$word" ]= $cnt;
        }
        arsort($result);

// Ищем словосочетания
        $words = preg_split( '#\s+#', trim( $text ) );
        $pair_words = array();

        foreach ( $words as $i => $word ) {
            if ( isset( $words[$i+1] )  ) {
                $pair_words[] = $word.' '.$words[$i+1];
            }
        }

        $pair_words = array_count_values( $pair_words );
        foreach( $pair_words as $key=>$value )
            if( $value==1 )unset( $pair_words[$key] );

        arsort($pair_words);

        $result = array_merge( $pair_words, $result );

        return $result;
    }
}
