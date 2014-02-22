<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Туристические новости'
    )
));
?>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_content", "template"=>"catalog_content", "url"=>"news",
        "title"=>"Туристические новости",
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sort"=>
        array(
            array( "col", "просмотрам" ),
            array( "name", "названию" ),
        )
    ) ) ?>
</div>