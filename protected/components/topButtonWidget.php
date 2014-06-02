<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class topButtonWidget extends CWidget
{
    var $type;
    public function run()
    {
        $template = "topButton";
        if( Yii::app()->getLanguage() == 'en' )$template .= "_en";

        $this->render( $template, array(
                    'type'      =>  $this->type
            ));
    }
}
