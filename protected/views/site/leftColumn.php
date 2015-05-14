<?php $this->widget("findFormWidget") ?>
<?php $this->widget("authWidget"); ?>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
</div>