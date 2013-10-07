<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туристические фирмы'
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_firms", "template"=>"catalog_firms", "url"=>"firms",
    "title" => "Туристические фирмы",
    "sort"=>
    array(
        array( "col", "просмотрам" ),
        array( "name", "названию" ),
    )
) ) ?>
</div>