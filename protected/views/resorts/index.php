<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            Yii::t("page", "Курорты, зоны отдыха, дет. лагеря")
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_kurorts", "template"=>"catalog_resorts", "url"=>"resorts",
                "title"=>Yii::t("page", "Курорты, зоны отдыха, дет. лагеря"),
                "description" => $this->description,
                "keyWord" => $this->keyWord,
                "sectionTextSlug" => array(
                                        "ru"=>"tekstovka-dlya-stranicy-kurorty",
                                        "ja"=>"8522-リゾートへtekstovkaページ",
                                        "zh"=>"8522-tekstovka页面度假酒店",
                                        "en"=>"8522-tekstovka-page-to-resorts",
                                    ),
                "sort"=>
                    array(
                        array( "col", Yii::t("page", "просмотрам" ) ),
                        array( "name", Yii::t("page", "названию" ) ),
                    )
) ) ?>
</div>