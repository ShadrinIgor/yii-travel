<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
                Yii::t("page", "Отели")
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_hotels", "template"=>"catalog_hotels", "url"=>"hotels",
                "title"=> Yii::t("page", "Отели"),
                "description" => $this->description,
                "keyWord" => $this->keyWord,
                "sectionTextSlug" => array(
                                        "ru"=>"tekstovka-dlya-stranicy-oteli",
                                        "ja"=>"8521-ページのホテルの宿泊tekstovka",
                                        "zh"=>"8521-tekstovka的页酒店",
                                        "en"=>"8521-tekstovka-for-page-hotels",
                                    ),
                "sort"=>
                    array(
                        array( "col", Yii::t("page", "просмотрам") ),
                        array( "level", Yii::t("page", "уровню" ) ),
                        array( "name", Yii::t("page", "названию") ),
                    )
) ) ?>
</div>