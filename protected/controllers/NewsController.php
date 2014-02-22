<?php

class NewsController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogContent";
        $this->classCategory = "";
        $this->description = "Самые популярные отели мира, отсортированные по рейтингу. Возможноть просмотра подробного описания";
        $this->keyWord = "Мировые новости,новости туризма";
    }

}