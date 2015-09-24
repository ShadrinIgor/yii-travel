<div class="leftBlock">
    <?php $this->widget("authWidget"); ?>
    <div id="LMenu">
        <div class="MNHeader"><?= Yii::t("page", "Категории объявлений"); ?></div>
        <?php foreach( CatalogWorkCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "pos, name" ) ) as $item ) : ?>
            <div class="LMItem">
                <a href="<?= SiteHelper::createUrl( "/work" )."/".$item->slug ?>.html" title="<?= $item->name ?> - <?= Yii::t("page", "категория частных объявлений"); ?>"><?= $item->name ?></a>
            </div>
        <?php endforeach; ?>
    </div>
    <br/>
    <div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
    <br/>
    <?php $this->widget("findFormWidget") ?>
    <div id="LeftBG">
        <?php $this->widget("infoWidget", array( "class"=>"CatalogContent", "link"=>"/news", "category_id"=>2 )); ?>
        <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
    </div>
</div>
