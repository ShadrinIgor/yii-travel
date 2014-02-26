<?php

class CatalogCCModelHelper extends CCModelHelper
{
    static function addForm( $form, $captcha = false, Controller $controller = null  )
    {
        $cout = parent::addForm( $form, $captcha, $controller );
        if( is_object( $form->param ) )
        {
            $cout .= "<tr><td colspan=\"2\"><h2>Параметры</h2>";
            $cout .= '<table border="0" id="addFormDopParam" width="500" cellpadding="6" cellspacing="6" class="tableForm">';
            $cout .= parent::addForm( $form->param, $captcha, $controller );
            $cout .= "</table>";
            $cout .= "</td></tr>";
        }

        return $cout;
    }
}
