<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туристические странны'
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_country", "template"=>"catalog_country", "url"=>"country",
        "title"=>"Страны",
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sort"=>
        array(
            array( "col", "просмотрам" ),
            array( "name", "названию" ),
        )
    ) ) ?>
</div>