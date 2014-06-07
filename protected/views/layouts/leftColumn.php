<?php $this->widget("findFormWidget") ?>

<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogContent", "link"=>"/news", "category_id"=>2 )); ?>
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
</div>
