<?php

class NewsController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogContent";
        $this->classCategory = "";
        $this->description = Yii::t("page", "Самые популярные отели мира, отсортированные по рейтингу. возможность просмотра подробного описания");
        $this->keyWord = Yii::t("page", "Мировые новости,новости туризма");
    }

}