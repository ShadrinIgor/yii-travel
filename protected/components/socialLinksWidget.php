<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class socialLinksWidget extends CWidget
{
    var $id = "share";
    var $url = "";
    public function run()
    {
        /*
        if(  $this->beginCache( "socialLink_block", array('duration'=>3600) ) )
        {
            if( !$this->url )$this->url = SiteHelper::createUrl("").$_SERVER["REQUEST_URI"];
            $this->render( "socialLink", array( "id"=>$this->id, "url"=>$this->url ) );
            $this->endCache();
        }
        */
    }
}
