<?php

class LanguagesController extends Controller
{
    public function actionIndex()
	{
        $lang = Yii::app()->request->getParam("language");
        $this->layout = '//layouts/main2';

        $url = str_replace( $lang."/", "", SiteHelper::createUrl("/").$_SERVER["REQUEST_URI"] );
        $url = str_replace( "//", "/", $url );
        $url = str_replace( "http:/", "http://", $url );

        switch( $lang )
        {
            case "en": $title = "The page you requested is temporarily unavailable";
                       $description = "This page is under construction. Maybe this page is available in Russian language.<a href=\"".$url."\"> ( ".$url." )</a>";
                    break;

            case "ja": $title = "あなたが要求したページは一時的に利用できません";
                        $description = "このページは工事中です。たぶん、このページでは、ロシア語で利用可能です.<a href=\"".$url."\"> ( ".$url." )</a>";
                    break;

            case "zh": $title = "您請求的頁面暫時不可用";
                        $description = "本頁面正在建設中。也許這頁是俄語語言.<a href=\"".$url."\"> ( ".$url." )</a>";
                    break;

            default : $title = "Страница, которую вы запрашиваете, временно недоступна";
        }

        Yii::app()->page->title = $title;
        Yii::app()->language = "ru";
        $this->render('error', array( "title"=>$title, "description"=>$description, "controller"=>$this, "content"=>"", "items"=>array() ) );

	}
}