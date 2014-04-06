<div id="LMenu">
    <div class="MNHeader">Категории объявлений</div>
    <?php foreach( CatalogItemsCategory::fetchAll() as $item ) : ?>
        <div class="LMItem">
            <a href="<?= SiteHelper::createUrl( "/adsUsers" )."/".$item->slug ?>.html" title="<?= $item->name ?> - категория частных объявлений"><?= $item->name ?></a>
        </div>
    <?php endforeach; ?>
</div>
<br/>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogContent", "link"=>"/news", "category_id"=>2 )); ?>
    <?php $this->widget("infoWidget", array( "title"=>"Информация туристу", "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
</div>
