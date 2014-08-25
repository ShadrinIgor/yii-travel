<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
                Yii::t("page", "Туристические странны мира")
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_country", "template"=>"catalog_country", "url"=>"country",
        "title"=>Yii::t("page", "Туристические странны мира"),
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sectionTextSlug" =>array(
                                "ru"=>"tekstovka-dlya-stranicy-strany",
                                "ja"=>"8519-国のためtekstovkaページ",
                                "zh"=>"8519-tekstovka页country",
                                "en"=>"8519-tekstovka-page-for-country",
                            ),
        "sort"=>
        array(
            array( "col", Yii::t("page", "просмотрам") ),
            array( "name", Yii::t("page", "названию") ),
        )
    ) ) ?>
</div>