<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Туры'
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_tours", "template"=>"catalog_tours", "title"=>"Туры" ) ) ?>
</div>