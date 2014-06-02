<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            Yii::t("page", "Акции и скидка от компании")
            )
    ));
?>
<div id="catalogItems">
<?php $this->widget( "pageWidget", array( "catalog"=>"catalog_firms_items", "template"=>"catalog_firms_items",
    "title"=>Yii::t("page", "Акции и скидка от комании"),
    "description" => $this->description,
    "keyWord" => $this->keyWord,
) ) ?>
</div>