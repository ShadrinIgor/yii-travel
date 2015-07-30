<div class="leftBlock">
    <?php $this->widget("findFormWidget") ?>
    <div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
    <div id="LeftBG">
        <?php $this->widget("infoWidget", array( "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
    </div>
</div>
