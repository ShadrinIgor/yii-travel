<?php

class trainingsWidget extends CWidget
{
    var $template = "trainings_firstStep" ;
    public function run()
    {
        $this->render( $this->template, array(
            ));
    }
}
