<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            Yii::t("travelAgency", "Туристические агенства")
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_firms", "template"=>"catalog_firms", "url"=>"travelAgency",
    "title" => Yii::t("travelAgency", "Туристические агентства"),
    "sectionTextSlug" => array(
                            "ru"=>"tekstovka-dlya-stranicy-firmy",
                            "en"=>"8524-tekstovka-page-for-firms",
                            "zh"=>"8524-tekstovka页面换行",
                            "ja"=>"8524-企業のtekstovkaページ",
                        ),
    "order" => "rating DESC",
    "sort"=>
    array(
        array( "col", Yii::t("page", "просмотрам" ) ),
        array( "name",Yii::t("page", "названию") ),
    )
) ) ?>
</div>