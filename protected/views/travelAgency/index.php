<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туристические агентства'
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_firms", "template"=>"catalog_firms", "url"=>"travelAgency",
    "title" => "Туристические агентства",
    "sectionTextSlug" => "tekstovka-dlya-stranicy-firmy",
    "order" => "edit_date DESC, id DESC",
    "sort"=>
    array(
        array( "col", "просмотрам" ),
        array( "name", "названию" ),
    )
) ) ?>
</div>