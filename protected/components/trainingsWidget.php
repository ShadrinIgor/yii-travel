<?php

class trainingsWidget extends CWidget
{
    var $template = "trainings_firstStep" ;
    var $param = array();
    public function run()
    {
        $this->render( $this->template, $this->param );
    }
}
