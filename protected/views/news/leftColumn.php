<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Курорты"), "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>
    <div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "right" ) ?></div>
    <?php $this->widget("infoWidget", array( "title"=>"Туры", "class"=>"CatalogTours", "link"=>"/tours" )); ?>
</div>

