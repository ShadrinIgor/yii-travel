<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
                Yii::t("page", "Туристические странны мира")
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_country", "template"=>"catalog_country", "url"=>"countryPage",
        "title"=>Yii::t("page", "Туристические странны мира"),
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "order"=> "id",
        "sectionTextSlug" =>array(
                                "ru"=>"tekstovka-dlya-stranicy-strany",
                                "en"=>"8519-tekstovka-page-for-country",
                            ),
        "sort"=>
        array()
    ) ) ?>
</div>