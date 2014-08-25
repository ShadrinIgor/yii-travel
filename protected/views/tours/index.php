<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
               Yii::t("page", "Туры")
            )
    ));

?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_tours", "template"=>"catalog_tours",
    "title"=>Yii::t("page", "Туры"),
    "description" => $this->description,
    "keyWord" => $this->keyWord,
    "sectionTextSlug" => array(
                "ru"=>"tekstovka-dlya-stranicy-tury",
                "ja"=>"8520-ツアーのtekstovkaページ",
                "ch"=>"8520-tekstovka页旅行团",
                "en"=>"8520-tekstovka-page-for-tours",
                            ),
) ) ?>
</div>