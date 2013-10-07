<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туристическая информация'
            )
    ));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_info", "template"=>"catalog_info", "url"=>"info",
        "title"=>"Туристическая информация",
        "sort"=>
        array(
            array( "col", "просмотрам" ),
            array( "name", "названию" ),
        )
    ) ) ?>
</div>