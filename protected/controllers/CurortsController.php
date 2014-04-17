<?php

class CurortsController extends Controller
{
    public function init()
    {
        $this->redirect( SiteHelper::createUrl("/resorts") );
    }
}