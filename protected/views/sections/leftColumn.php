<div id="LMenu">
    <div class="MNHeader"><?= Yii::t("page", "Разделы"); ?></div>
    <?php foreach( CatalogSections::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) : ?>
        <div class="LMItem">
            <a href="<?= SiteHelper::createUrl( "/sections" )."/".$item->slug ?>.html" title="<?= $item->name ?> - <?= Yii::t("page", "категория частных объявлений"); ?>"><?= $item->name ?></a>
        </div>
    <?php endforeach; ?>
</div>
<br/>
<div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
<br/>
<?php $this->widget("findFormWidget") ?>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogContent", "link"=>"/news", "category_id"=>2 )); ?>
</div>
