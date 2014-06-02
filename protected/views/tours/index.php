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
    "sectionTextSlug" => "tekstovka-dlya-stranicy-tury",
) ) ?>
</div>