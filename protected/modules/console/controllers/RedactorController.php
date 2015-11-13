<?php

class RedactorController extends ConsoleController
{
    public function init()
    {
        parent::init();
        $this->layout ='console.views.layouts.main';
    }

	public function actionIndex()
	{
        $this->render( "index" );
	}
};