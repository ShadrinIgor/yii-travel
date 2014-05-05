<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'туристические акции, скидки, спец предложения'
            )
    ));

?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_firms_items", "template"=>"catalog_sales",
    "title"=>"Акции, скидки, спец предложения",
    "description" => $this->description,
    "url" => "sales",
    "keyWord" => $this->keyWord,
    "sectionTextSlug" => "",
) ) ?>
</div>