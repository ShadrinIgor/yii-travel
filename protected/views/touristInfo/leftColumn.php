<?php $this->widget("findFormWidget") ?>
<div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogTours", "link"=>"/tours" )); ?>
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Зоны отдыха"), "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>
</div>
