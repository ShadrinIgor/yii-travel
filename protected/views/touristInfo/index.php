<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туристическая информация'
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_info", "template"=>"catalog_info", "url"=>"touristInfo",
        "title"=>"Туристическая информация, информация для туристов",
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sectionTextSlug" => "tekstovka-dlya-stranicy-o-turizme",
        "sort"=>
        array(
            array( "col", "просмотрам" ),
            array( "name", "названию" ),
        )
    ) ) ?>
</div>