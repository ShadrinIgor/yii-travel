<div id="LMenu">
    <div class="MNHeader">Города</div>
    <?php foreach( CatalogCity::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid AND id in(1,2,3,4,6,7,8)")->setParams( array(":cid"=>1) )->setOrderBy( "name" )->setLimit(-1) ) as $item ) : ?>
        <div class="LMItem">
            <a href="<?= SiteHelper::createUrl( "/attractions" ).$item->slug ?>.html" title="<?= $item->name ?>"><?= $item->name ?></a>
        </div>
    <?php endforeach; ?>
</div>
<div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
<br/>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
</div>
