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
                "sectionTextSlug" => "tekstovka-dlya-stranicy-kurorty",
                "sort"=>
                    array(
                        array( "col", Yii::t("page", "просмотрам" ) ),
                        array( "name", Yii::t("page", "названию" ) ),
                    )
) ) ?>
</div>