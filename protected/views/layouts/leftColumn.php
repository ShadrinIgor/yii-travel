<?php $this->widget("newsWidget"); ?>
<div class="IILeft">
    <div id="ILHeder01">Статьи о туризме</div>

    <?php
    $items = CatalogInfo::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("rand(id)")->setLimit( 6 ) );
    ?>
    <?php foreach( $items as $item ) : ?>
        <div class="ILItems">
            <a href="<?= SiteHelper::createUrl( "/info/description", array("id"=>$item->id) ) ?>" title="<?= $item->name ?>" class="ILIHed"><?= $item->name ?></a>
            <?php if( $item->image ) : ?><div class="LI ImageLimit"><a href="<?= SiteHelper::createUrl( "/info/description", array("id"=>$item->id) ) ?>" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a></div><?php endif; ?>
            <?= SiteHelper::getSubTextOnWorld( $item->name, 200 ) ?>
            <p class="itemPar">Категория:<a href="<?= SiteHelper::createUrl( "/info", array("id"=>$item->category_id->id) ) ?>" title="<?= $item->category_id->name ?>"><?= $item->category_id->name ?></a></p>
        </div>
    <?php endforeach; ?>
    <a title="остальные" class="mLinks" href="info/">остальные ...</a>
</div>