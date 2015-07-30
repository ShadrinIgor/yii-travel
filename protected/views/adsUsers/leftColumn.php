<div class="leftBlock">
    <div id="LMenu">
        <div class="MNHeader"><?= Yii::t("page", "Категории объявлений"); ?></div>
        <?php foreach( CatalogItemsCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "pos, name" ) ) as $item ) : ?>
            <div class="LMItem">
                <a href="<?= SiteHelper::createUrl( "/adsUsers" )."/".$item->slug ?>.html" title="<?= $item->name ?> - <?= Yii::t("page", "категория частных объявлений"); ?>"><?= $item->name ?></a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
    <br/>
    <div id="LeftBG">
        <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
    </div>
</div>