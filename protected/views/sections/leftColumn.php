<div id="LMenu">
    <div class="MNHeader">Разделы</div>
    <?php foreach( CatalogSections::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) : ?>
        <div class="LMItem">
            <a href="<?= SiteHelper::createUrl( "/sections" )."/".$item->slug ?>.html" title="<?= $item->name ?> - категория частных объявлений"><?= $item->name ?></a>
        </div>
    <?php endforeach; ?>
</div>
<br/>
<?php $this->widget("findFormWidget") ?>
<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogContent", "link"=>"/news", "category_id"=>2 )); ?>
</div>
