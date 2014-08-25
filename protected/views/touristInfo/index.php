<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            Yii::t("page", "Туристическая информация")
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_info", "template"=>"catalog_info", "url"=>"touristInfo",
        "title"=>Yii::t("page", "Туристическая информация, информация для туристов"),
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sectionTextSlug" => array(
                            "ru"=>"tekstovka-dlya-stranicy-o-turizme",
                            "en"=>"8523-tekstovka-page-for-on-tourism",
                            "zh"=>"8523-tekstovka页桃杏",
                            "ja"=>"8523-オン観光のためtekstovkaページ",
                ),
        "sort"=>
        array(
            array( "col", Yii::t("page", "просмотрам") ),
            array( "name", Yii::t("page", "названию") ),
        )
    ) ) ?>
</div>