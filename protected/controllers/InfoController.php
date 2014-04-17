<?php

class InfoController extends Controller
{
    public function init()
    {
        $this->redirect( SiteHelper::createUrl("/touristInfo") );
    }
}