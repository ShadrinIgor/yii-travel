<?php $this->widget("findFormWidget") ?>
<div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
</div>

