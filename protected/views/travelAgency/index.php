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
    "sectionTextSlug" => "tekstovka-dlya-stranicy-firmy",
    "order" => "edit_date DESC, id DESC",
    "sort"=>
    array(
        array( "col", Yii::t("page", "просмотрам" ) ),
        array( "name",Yii::t("page", "названию") ),
    )
) ) ?>
</div>