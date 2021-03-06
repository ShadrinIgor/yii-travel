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
    public static function setLog( $catalog, $action, $itemId, $userId=0 )
    {
        $newLog = new CatLog();
        $newLog->catalog = $catalog;
        $newLog->action = $action;
        $newLog->item_id = $itemId;
        $newLog->user_id = $userId;
        $newLog->date = time();
        $newLog->date2 = date("Y-m-d");
        $newLog->save();
    }

    public static function getAnimateText( $slug, $link = "" )
    {
        if( is_array( $slug ) )
        {
            if( !empty( $slug[ Yii::app()->getLanguage() ] ) )$slug = $slug[ Yii::app()->getLanguage() ];
                                    else $slug = "";

        }

        if( !empty( $slug ) )
        {
            $textModel = CatalogContent::fetchBySlug( $slug );
            $cout = '<div class="blockquote">'.$textModel->description;
            if( !empty( $link ) )$cout .= "<div class='textAlignRight'><a href='".$link."' title='".Yii::t( "page", "подробнее о туристическом портале Узбекистана")."'>".Yii::t( "page", "подробнее" )."...</div>";
            $cout .='</div>';
            return $cout;
        }
    }

    public static function checkWWW( $www )
    {
        if( strpos( $www, "http://" ) === false )$www = "http://".$www;
        return $www;
    }

    public static function getSlug( CCModel $item )
    {
        if( empty( $item->slug ) || !$item->slug)
        {
            $nameForSlag = str_replace( array("\$"), "", $item->name );
            $nameTranstlit = SiteHelper::getTranslateForUrl( $nameForSlag );
            $dopSlug = $item->id."-";
            if( property_exists( $item, "owner" ) && $item->owner->id >0 )$dopSlug .= SiteHelper::getTranslateForUrl( $item->owner->name );
                                              else $dopSlug .= "";

            if( property_exists( $item, "category_id" ) && !empty( $item->category_id ) && $item->category_id->id >0 )$dopSlug .= SiteHelper::getTranslateForUrl( $item->category_id->name );

            if( get_class( $item ) == "CatalogHotels" )
            {
                $dopSlug = SiteHelper::getTranslateForUrl( $item->country_id->name );
                if( $item->city_id->id >0 )$dopSlug .= "-".SiteHelper::getTranslateForUrl( $item->city_id->name );
            }


            // Проверяем чтобы название категории не содержалось в названии чтобы не было такого: banki-banki-tashkenta
            if( !empty( $dopSlug ) && strpos( $nameTranstlit, $dopSlug ) !== false  )$dopSlug .= "";

            if( !empty( $dopSlug ) )$item->slug = $dopSlug ."-". $nameTranstlit;
                               else $item->slug = $nameTranstlit;

            $item->slug = str_replace( array( "---", "--" ), "-", $item->slug );
            $item->save();
        }

        return $item->slug;
    }
	
    static function mailto($subject, $from = "", $to, $msg, $copy='', $template='', $replaceArray = array(), $toName="", $fromName = "" )
    {
        if( empty( $template ) )$template = 'main.tpl';
        if( empty( $from ) )$from = Yii::app()->params['adminEmail'];
        if( empty( $from ) )$from = "info@world-travel.uz";
        if( empty( $fromName ) )$fromName = "World-Travel.uz";
        if( empty( $toName ) )
        {
            $toName = substr( $to, 0, strpos( $to, "@" ) );
        }

/*        $header="Date: ".date("D, j M Y G:i:s")." +0500\r\n";
        $header.="From: =?UTF-8?B?".base64_encode( $fromName )."?= <".$from.">\r\n";
        $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
        $header.="Reply-To: =?UTF-8?B?".base64_encode( $fromName )."?= <".$from.">\r\n";
        $header.="X-Priority: 3 (Normal)\r\n";
        $header.="Message-ID: <172562218.".date("YmjHis")."@".Yii::app()->params["mail-host"].">\r\n";
        $header.="To: =?UTF-8?B?".base64_encode( $toName )."?= <".$to.">\r\n";
        $header.="Subject: =?UTF-8?B?".base64_encode( $subject )."?=\r\n";
        $header.="MIME-Version: 1.0\r\n";
        $header.="Content-Type: text/html; charset=UTF-8\r\n";
        $header.="Content-Transfer-Encoding: base64\r\n";

        if( $template && file_exists( "f/mails_template/".$template) )
        {
            $fullUrl = "f/mails_template/".$template;
            $file = fopen( $fullUrl, "r+" );
            $templateText = fread( $file, filesize( $fullUrl ) );
            fclose( $file );
            $msg = str_replace( "@cotent_text@", $msg, $templateText );
        }*/

        $replaceArray[ "src='f/" ] = Yii::app()->params["baseUrl"]."f/";
        if( sizeof($replaceArray)>0 )
        {
            foreach( $replaceArray as $key=>$value )
            {
                $msg = str_replace( $key, $value, $msg );
            }
        }

        SubscribesUzHelper::sendEmail($toName, $to, $subject, "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;overflow: hidden;\">".$msg."</div>", 2, 1);

        /*$text=base64_encode( $msg );

        $smtp_conn = fsockopen("92.63.109.197", 25,$errno, $errstr, 10);
        $data = SiteHelper::get_data($smtp_conn);
        $log = $data." | ";

//        echo "EHLO ".Yii::app()->params["mail-host"]."\r\n";
        fputs($smtp_conn,"EHLO ".Yii::app()->params["mail-host"]."\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

//        echo "AUTH LOGIN\r\n";
        fputs($smtp_conn,"AUTH LOGIN\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

//        echo base64_encode( Yii::app()->params["mail-log"] )."\r\n";
        fputs($smtp_conn,base64_encode( Yii::app()->params["mail-log"] )."\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

//        echo base64_encode( Yii::app()->params["mail-pass"] )."\r\n";
        fputs($smtp_conn,base64_encode( Yii::app()->params["mail-pass"] )."\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

        fputs($smtp_conn,"MAIL FROM:".$from."\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

        fputs($smtp_conn,"RCPT TO:".$to."\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

        fputs($smtp_conn,"DATA\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

        fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

        fputs($smtp_conn,"QUIT\r\n");
        $data = SiteHelper::get_data($smtp_conn);
        $log .= $data." | ";

        $newLog = new CatLog();
        $newLog->email = $to;
        $newLog->del = 1;
        $newLog->date2 = Date( "d.m.Y H:i" );
        $newLog->description = $log;
        $newLog->action = "subscribe";
        if( !$newLog->save() )
            print_r( $newLog->getErrors() );*/
    }

    static function get_data($smtp_conn)
    {
        $data="";
        while($str = fgets($smtp_conn,515))
        {
            $data .= $str;
            if(substr($str,3,1) == " ") { break; }
        }
        return $data;
    }

/*
    static function mailto($subject, $from = "", $to, $msg, $copy='', $template='', $replaceArray = array())
    {
        if( empty( $template ) )$template = 'main.tpl';
        if( empty( $from ) )$from = Yii::app()->params['adminEmail'];
        if( empty( $from ) )$from = "info@world-travel.uz";
        $error = null;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=cp1251' . "\r\n";

        $headers .= 'Date: '.date("r")."\r\n";
        $headers .= 'To: '.$to." \r\n";
        $headers .= 'From: '.$from. "\r\n";
        if( !empty( $copy ) )$headers .= "Bcc: ".$copy."\r\n";

        if( $template && file_exists( "f/mails_template/".$template) )
        {
            $fullUrl = "f/mails_template/".$template;
            $file = fopen( $fullUrl, "r+" );
            $templateText = fread( $file, filesize( $fullUrl ) );
            fclose( $file );
            $msg = str_replace( "@cotent_text@", $msg, $templateText );
        }

        $headers = iconv("UTF-8", "cp1251", $headers);
        $msg = iconv("UTF-8", "cp1251", $msg);
        $subject = iconv("UTF-8", "cp1251", $subject);

        $replaceArray[ "@content_link@" ] = Yii::app()->params["baseUrl"]."site/unSubscribe/email/".$to."/hash/".( substr( md5( md5( $to ) ), 3, 8 ) );
        if( sizeof($replaceArray)>0 )
        {
            foreach( $replaceArray as $key=>$value )
            {
                $msg = str_replace( $key, $value, $msg );
            }
        }

        //echo $to.",".$subject.",".$msg.",".$headers;
        $res=@mail($to,$subject,$msg,$headers);
        if($res===false)$error="Произошла ошибка отправки сообщения на E-mail (<b>".$to."</b>). Проверте коректность вводимого E-mail и попробуйте снова.";

        return $error;
    }*/

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
            "Ь"=>"","Б"=>"B","Ю"=>"YU", "”"=>"", "“"=>"",
            "«"=>"","»"=>""," "=>"-",

            "\""=>"", "\."=>"", "–"=>"-", "\,"=>"", "\("=>"", "\)"=>"",
            "\?"=>"", "\!"=>"", "\:"=>"", "\+"=>"", "\$"=>"", '&039;'=>"", "&"=>"", "%"=>"",

            '#' => '', '№' => '',' - '=>'-', '/'=>'-', '  '=>'-', '\*'=>'', '“'=>"",
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

    static function createUrl($route,$params=array(),$ampersand='&', $isBase = false )
    {
        if( Yii::app()->getLanguage() != "ru" && !$isBase )$urlLang = Yii::app()->getLanguage()."/";
                                          else $urlLang = "";

        if( $route == "/" && empty( $params ) )return Yii::app()->params["baseUrl"].$urlLang;
            else
        {
            if($route==='')
                $route=Yii::app()->controller->Id.'/'.Yii::app()->controller->action->Id;
            else if(strpos($route,'/')===false)
                $route=Yii::app()->controller->Id.'/'.$route;
            if($route[0]!=='/' && ($module=Yii::app()->controller->module)!==null)
                $route=$module->getId().'/'.$route;

            if( defined("YII_SUBDOMAIN") )$paramName = YII_SUBDOMAIN."baseUrl";
                                     else $paramName = "baseUrl";


            $url = Yii::app()->params[ $paramName ].$urlLang.Yii::app()->createUrl(trim($route,'/'),$params,$ampersand);
            $url = str_replace("//","/", $url);
            $url = str_replace(":/","://", $url);

            return $url;
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
        $text = strip_tags( $text);
        if( strlen( $text )>$count )
        {
            $cout = substr( $text, 0, $count );
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
                return "";
                //trigger_error( "Не правельный формат переданной даты ( Класс: ".$classNme." | Дата: ".$date." ".$note.")", E_USER_NOTICE );

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
        }
        return $value;
    }

    /*
      * Сохранение связанных элементов таблицы, тип связи MANY_MANY
      * @param CCModel $model
      * @param Array $values
      */
    static function saveRelation( CCModel $model, $values )
    {
        foreach( $model->relations() as $value )
        {
            if( $value[0] == "CManyManyRelation" )
            {
                $leftClass = $value[1];
                $rightClass = SiteHelper::getCamelCase( $model->tableName() );
                CatRelations::sql("DELETE FROM cat_relations WHERE ( leftClass='".$leftClass."' AND rightClass='".$rightClass."') OR ( leftClass='".$rightClass."' AND rightClass='".$leftClass."') ");
                foreach( $values as $value2 )
                {
                    $new =  new CatRelations();
                    $new->leftClass = $leftClass;
                    $new->rightClass = $rightClass;
                    $new->leftId = $value2;
                    $new->rightId = $model->id;
                    $new->save();

                    $new =  new CatRelations();
                    $new->leftClass = $rightClass;
                    $new->rightClass = $leftClass;
                    $new->leftId = $model->id;
                    $new->rightId = $value2;
                    $new->save();
                }
            }
        }
    }

    /*
     * Проверка корректности Slug для ссылок
     */
    static function checkedSlugName( $slug )
    {
        $rus=array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ш","щ","ы","ь","ъ","э","ю","я"," ",".","-","(",")","j","w");
        $eng=array("a","b","v","g","d","e","e","sh","z","i","i","k","l","m","n","o","p","r","s","t","u","f","h","c","sh","sch","i","","","e","yu","ya","_",".","_","(",")","j","w");
        $slug = str_replace( $rus, $eng, $slug );

        $arrayReplace = array( '$', "&", "?", "#" );
        $arrayReplace = str_replace( $arrayReplace, "", $slug );

        $arrayReplace = array( " - ", ' ', "_" );
        return str_replace( $arrayReplace, "-", $slug );
    }

    // Передача закрытой информации такой как email и название сайта не текстом а картинкой
    static public function getAccessInfo( )
    {
        $catalog = Yii::app()->request->getParam("catalog","");
        $id = (int)Yii::app()->request->getParam("id",0);
        $field = Yii::app()->request->getParam("field","");

        // Для передачи возможны только следующие поля
        $arraList = array("email", "www");
        if( !in_array($field, $arraList ) )$field="";

        if( $id>0 && !empty( $field ) && !empty( $catalog ) )
        {
            if( class_exists( $catalog ) )
            {
                $itemModel = $catalog::fetch( $id );
                if( $itemModel->id > 0 && property_exists( $itemModel, $field ) )
                {
                    Yii::app()->ih
                        ->load($_SERVER['DOCUMENT_ROOT'] . '/f/temp/1.jpg')
                        ->text( $itemModel->$field, $_SERVER['DOCUMENT_ROOT'] . '/themes/classic/font/georgia.ttf',
                            11, array(2,95,160), CImageHandler::CORNER_LEFT_BOTTOM, 3, 3)
                        ->save($_SERVER['DOCUMENT_ROOT'] . '/f/temp/2.jpg');

                    echo '<img src="/f/temp/2.jpg" />';
                }
            }
        }
    }
}
