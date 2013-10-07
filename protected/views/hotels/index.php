<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Отели'
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_hotels", "template"=>"catalog_hotels", "url"=>"hotels",
                "title"=>"Отели",
                "sort"=>
                    array(
                        array( "col", "просмотрам" ),
                        array( "level", "уровню" ),
                        array( "name", "названию" ),
                    )
) ) ?>
</div>