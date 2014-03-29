<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 */
class formNoteWidget extends CWidget
{
    var $type = "formNote";
    public function run()
    {
        $this->render( $this->type, array());
    }
}
