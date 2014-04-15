<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туристические странны мира'
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_country", "template"=>"catalog_country", "url"=>"country",
        "title"=>"Туристические странны мира",
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sectionTextSlug" => "tekstovka-dlya-stranicy-strany",
        "sort"=>
        array(
            array( "col", "просмотрам" ),
            array( "name", "названию" ),
        )
    ) ) ?>
</div>