<?php

class FirmsController extends Controller
{
    public function init()
    {
        $this->redirect( SiteHelper::createUrl("/travelAgency") );
    }
}