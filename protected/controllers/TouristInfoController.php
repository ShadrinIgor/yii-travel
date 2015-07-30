<?php

class TouristInfoController extends InfoController
{
	public function init()
    {
        parent::init();
        $this->layout = '//layouts/main2';
        $this->classModel = "CatalogInfo";
        $this->classCategory = "CatalogInfoCategory";
        $this->description = Yii::t("tourisInfo", "Полезная информация для туристов и людей любящих путешествия. Здесь представлена информация о мировой архитектуре, авиатранспорт, виза в Узбекистан, здоровье/питание и т.д.");
        $this->keyWord = Yii::t("tourisInfo", "Полезная информация для туристов, архитектура, базары Узбекистана, банки Ташкента, великие люди, великий шелковый путь, автобусные путешествия, виза в Узбекистан, дети, культура / искусства, разновидности туризма, экстремальный  туризм , рыбалка/охота, религия / духовные центры, кладбища");
    }
}