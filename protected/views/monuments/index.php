<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
               Yii::t("page", "Исторические достопримечательности Узбекистана")
            )
    ));

?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_monuments", "template"=>"catalog_monuments",
    "title"=> "Исторические достопримечательности Узбекистана",
    "description" => $this->description,
    "keyWord" => $this->keyWord,
    "sectionTextSlug" => array(
                "ru"=>"",
                "ja"=>"",
                "ch"=>"",
                "en"=>"",
    ),
) ) ?>
</div>