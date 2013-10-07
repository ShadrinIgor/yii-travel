<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Курорты, зоны отдыха'
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_kurorts", "template"=>"catalog_resorts", "url"=>"resorts",
                "title"=>"Курорты, зоны отдыха",
                "sort"=>
                    array(
                        array( "col", "просмотрам" ),
                        array( "name", "названию" ),
                    )
) ) ?>
</div>