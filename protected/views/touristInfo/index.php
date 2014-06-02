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
        "sectionTextSlug" => "tekstovka-dlya-stranicy-o-turizme",
        "sort"=>
        array(
            array( "col", Yii::t("page", "просмотрам") ),
            array( "name", Yii::t("page", "названию") ),
        )
    ) ) ?>
</div>