<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><a title="<?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( $url."/description", array( "id"=>$item->id, "slug"=> SiteHelper::getSlug( $item ) )) ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= SiteHelper::getStringForTitle( $item->name ) ?>" /></a></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( $url."/description", array( "id"=>$item->id, "slug"=> SiteHelper::getSlug( $item ) )) ?>"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <a href="<?= SiteHelper::createUrl("country/", array( "slug"=>$item->country_id->slug )) ?>" title="<?= $item->country_id->name ?>">Страна: <b><?= $item->country_id->name ?></b></a><br/>
            Туров: <b><?= CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams(array(":firm_id"=>$item->id)) ) ?></b><br/>
        </div>
        <?= CCmodelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>