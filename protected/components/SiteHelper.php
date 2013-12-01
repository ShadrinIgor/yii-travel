<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Колоюок
 * Date: 27.09.12
 * Time: 1:20
 * To change this template use File | Settings | File Templates.
 */
class SiteHelper
{
    public static function getSlug( CCModel $item )
    {
        if( empty( $item->slug ) || !$item->slug)
        {
            $item->slug = SiteHelper::getTranslateForUrl( $item->name );
            $item->save();
            if( $item->getErrors() )
                throw new CHttpException( "Ошибка сохранения SLUG ( ".get_class( $item )." )", print_r( $item->getErrors(), true) );
        }

        return $item->slug;
    }

    public static function getConfig( $key )
    {
        $configModel = ConfigOptions::fetchByKeyWord( $key );
        if( $configModel && $configModel->id >0 )
        {
            return $configModel->value;
        }

        return false;
    }

    public static function getTranslateForUrl( $text )
    {
        if( !empty( $text ) )return SiteHelper::translate( trim( $text ) );
        return false;
    }

    public static function getLanguage()
    {
        return 1;
    }

    /*
     * Выводит уровень в ввиде количества звезд
 */
    public static function getStarsLevel( $level = 0 )
    {
        if( $level >0 )
        {
            return Yii::app()->getTheme()->getBaseUrl()."/images/icons/level_".$level.".jpg";
        }

        return false;
    }

    public static function getCamelCase( $text )
    {
        $cout = str_replace( "_", " ", $text );
        $cout = ucwords( $cout );
        $cout = str_replace( " ", "", $cout );
        return $cout;
    }

    /**
     * Навещивает обработчики событий
     * @static
     * @param CComponent $object
     * @return object
     *
     */
    public static function attacheHandlers(CComponent &$object) {
        $config = SiteHelper::getEventsConfig();
        foreach($config as $event=>$handlers) {
            if(!method_exists(get_class($object), $event))
                continue;

            foreach($handlers as $handler)
                $object->attachEventHandler( $event, $handler );
               // $object->$event = $handler;
        }
    }

    public static function getEventsConfig() {
        return require(Yii::getPathOfAlias('configPath').DIRECTORY_SEPARATOR.'handlers.php');
    }

    /*
     * Функция делает транслит руских слов в английские
     */
    protected static function translate($text, $toLowCase = TRUE)
    {
        $matrix=array(
            "й"=>"i","ц"=>"c","у"=>"u","к"=>"k","е"=>"e","н"=>"n",
            "г"=>"g","ш"=>"sh","щ"=>"shch","з"=>"z","х"=>"h","ъ"=>"",
            "ф"=>"f","ы"=>"y","в"=>"v","а"=>"a","п"=>"p","р"=>"r",
            "о"=>"o","л"=>"l","д"=>"d","ж"=>"zh","э"=>"e","ё"=>"e",
            "я"=>"ya","ч"=>"ch","с"=>"s","м"=>"m","и"=>"i","т"=>"t",
            "ь"=>"","б"=>"b","ю"=>"yu",
            "Й"=>"I","Ц"=>"C","У"=>"U","К"=>"K","Е"=>"E","Н"=>"N",
            "Г"=>"G","Ш"=>"SH","Щ"=>"SHCH","З"=>"Z","Х"=>"X","Ъ"=>"",
            "Ф"=>"F","Ы"=>"Y","В"=>"V","А"=>"A","П"=>"P","Р"=>"R",
            "О"=>"O","Л"=>"L","Д"=>"D","Ж"=>"ZH","Э"=>"E","Ё"=>"E",
            "Я"=>"YA","Ч"=>"CH","С"=>"S","М"=>"M","И"=>"I","Т"=>"T",
            "Ь"=>"","Б"=>"B","Ю"=>"YU",
            "«"=>"","»"=>""," "=>"-",

            "\""=>"", "\."=>"", "–"=>"-", "\,"=>"", "\("=>"", "\)"=>"",
            "\?"=>"", "\!"=>"", "\:"=>"",

            '#' => '', '№' => '',' - '=>'-', '/'=>'-', '  '=>'-',
        );

        // Enforce the maximum component length
        $maxlength = 100;
        $text = implode(array_slice(explode('<br>',wordwrap(trim(strip_tags(html_entity_decode($text))),$maxlength,'<br>',false)),0,1));
        //$text = substr(, 0, $maxlength);

        foreach($matrix as $from=>$to)
            $text=mb_eregi_replace($from,$to,$text);

    // Optionally convert to lower case.
        if ($toLowCase)
        {
            $text = strtolower($text);
        }

        return $text;
    }

    /*
     *  Функция выводит путь для хранения картинок
     */
    static function getImagePath( $tableName, $id )
    {
        $imagePath = "f/";
        $imagePath .= $tableName."/";
        @mkdir( $imagePath );

        $imagePath .= date("Y")."/";
        @mkdir( $imagePath );

        $imagePath .= date("m")."/";
        @mkdir( $imagePath );

        $imagePath .= date("d")."/";
        @mkdir( $imagePath );

        if( !empty( $id ) )
        {
            $imagePath .=$id."/";
            @mkdir( $imagePath );
        }

        return $imagePath;
    }

    /*
     * Вункция возвращает правельный текст для alt и title
     */
    static function getStringForTitle( $value )
    {
        return str_replace( '"', "'", $value );
//        /
    }

    /*
     * Это часть необходимо для рендринга динамических блоков, типо rightColumn
     */
    static function renderDinamicPartial( $view, $data=array(), $return=false )
    {
        $controller = Yii::app()->controller;
        $viewPath = "";
        $output = "";

        if(($renderer=Yii::app()->getViewRenderer())!==null)
            $extension=$renderer->fileExtension;
        else
            $extension='.php';

        $countrollerVews = $controller->getViewPath().DIRECTORY_SEPARATOR.$view.$extension;
        $layoutsFolder = Yii::getPathOfAlias("viewsLayouts").DIRECTORY_SEPARATOR.$view.$extension;

        if( is_file( $countrollerVews ) )
        {
            $viewPath = $view;
        }
            elseif( is_file( $layoutsFolder ) )
            {
                $viewPath = "viewsLayouts.".$view;
            }

        if( !empty( $viewPath ) )
        {
            $output=$controller->renderPartial($viewPath,$data,true);

            if($return)
                return $output;
            else
                echo $output;
        }
    }

    static function createUrl($route,$params=array(),$ampersand='&')
    {
        if( $route == "/" && empty( $params ) )return Yii::app()->params["baseUrl"];
            else
        {
            if($route==='')
                $route=Yii::app()->controller->Id.'/'.Yii::app()->controller->action->Id;
            else if(strpos($route,'/')===false)
                $route=Yii::app()->controller->Id.'/'.$route;
            if($route[0]!=='/' && ($module=Yii::app()->controller->module)!==null)
                $route=$module->getId().'/'.$route;
            return Yii::app()->createUrl(trim($route,'/'),$params,$ampersand);
        }

    }

    /*
     * Вывод связанный элементов таблицы, тим свящи HAS_MANY | MANY_MANY
     * @param RelationParamsClass $relationParams параметры связи
     * @param DBQueryParamsClass $QBQueryPrams Определяет в каком прядке, какие запис необходимы втаскивать
     * @return array $list Возвращает масив объектов
     */
    static function getRelation( RelationParamsClass $relationParams, DBQueryParamsClass $QBQueryPrams = null )
    {
        if( empty( $QBQueryPrams ) )$QBQueryPrams = new DBQueryParamsClass();

        $relationClass = $relationParams->getRightClass();
        $relationObj = new $relationClass;
        $relationTable = $relationObj->tableName();

//        $sql = "SELECT a.* FROM ".$relationTable." a, cat_relations b WHERE b.leftClass='".$relationParams->getLeftClass()."' AND b.rightClass='".$relationParams->getRightClass()."' AND b.leftId='".$relationParams->getLeftId()."' AND a.id = b.rightId LIMIT ".$QBQueryPrams->getLimit();

        $sqlDopWhere = ( $QBQueryPrams->getConditions() ) ? " ( ".$QBQueryPrams->getConditions()." ) AND " : "";
        $sqlOrder = ( $QBQueryPrams->getOrderBy()=="id" ) ? "a.id" : $QBQueryPrams->getOrderBy();

        $result = Yii::app()->db->createCommand( )
                    ->select( "a.*" )
                    ->from( $relationTable." a, cat_relations b " )
                    ->where( $sqlDopWhere." ( b.leftClass='".$relationParams->getLeftClass()."' AND b.rightClass='".$relationParams->getRightClass()."' AND b.leftId='".$relationParams->getLeftId()."' AND a.id = b.rightId )", $QBQueryPrams->getParams() )
                    ->order( $sqlOrder )
                    ->queryAll();

        $list = array();
        if( is_array($result) && sizeof($result)>0 )
        {
            $obectClass = $relationParams->getRightClass();
            foreach( $result as $arrayValue )
            {
                $newObject =  new $obectClass;
                $newObject->setAttributesFromArray( $arrayValue );
                $list[ $newObject->id ] = $newObject;
            }
        }
        return $list;
    }

    /*
     * Обресайт текст по словам
     * @param text $text обрезаемый текст
     * @param int $count необходимое количество символов
     */
    static function getSubTextOnWorld( $text, $count )
    {
        if( strlen( $text )>$count )
        {
            $cout = substr( strip_tags( $text), 0, $count );
            $ar = explode( " ", $cout );
            $ar[ sizeof( $ar )-1 ] = "";
            $cout = implode( " ", $ar );
            $cout.=" ...";
        }
            else $cout = $text;

        return $cout;
    }

    /*
     * Вывод дату в заданном формате
     * @param string $date дата в формате YYYY-mm-dd
     * @param string $format формата даты
     */
    static function getDateOnFormat( $date, $format, $note = "" )
    {
        if( !empty( $date ) )
        {
            $classNme = get_called_class();
            if( strtotime( $date ) > 0 )$timeStamp = strtotime( $date );
                          else $timeStamp = $date;

            if( $timeStamp > 0 )
                return date( $format, $timeStamp );
            else
                trigger_error( "Не правельный формат переданной даты ( Класс: ".$classNme." | Дата: ".$date." ".$note.")", E_USER_NOTICE );

        }
         return false;
    }

    static function getTags( $tags )
    {
        return "<div class=\"newsTags\">".$tags."</div>";
    }

    /*
     * Рендерим динапичные блок сайта ( Например: rightColumn )
     * @param string $view название вьющки
     * @param array $data параметры для отображения
     * @param bool $return определяет варинт возврата данных
     */
    static function renderDynamicViews( $view,$data=array(),$return=false )
    {
        return Yii::app()->controller->renderDynamicViews( $view, $data, $return );
    }


    static function getParam( $fieldValue, $default_value = null, $type="string" )
    {
        $value = "";
        if( empty( $fieldValue ) && !empty( $_GET[ $fieldValue ] ) )$value = $_GET[ $fieldValue ];
        if( empty( $fieldValue ) && !empty( $_POST[ $fieldValue ] ) )$value = $_POST[ $fieldValue ];
        if( empty( $fieldValue ) && !empty( $default_value ) )$value = $default_value;
        return self::checkedVaribal( $fieldValue, $type );
    }

    /*
     * Проверка корректности входящих параметров
     */
    static function checkedVaribal( $value, $type="string" )
    {
        if( $type == "int" )$value = abs( (int)$value );
        if( $type == "string" )
        {
            $value = str_replace("'", "&#039;", $value);
            $value = trim( strip_tags( $value ) );
        }
        return $value;
    }

    /*
     * Проверка корректности Slug для ссылок
     */
    static function checkedSlugName( $slug )
    {
        $arrayReplace = array( '$', "&", "?", "#" );
        $arrayReplace = str_replace( $arrayReplace, "", $slug );

        $arrayReplace = array( " - ", ' ', "_" );
        return str_replace( $arrayReplace, "-", $slug );
    }
}
