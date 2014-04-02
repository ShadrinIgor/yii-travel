<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><a title="туристическое агенство <?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( "/travelAgency/description")."/".$item->slug ?>.html"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= SiteHelper::getStringForTitle( $item->name ) ?> туристическое агенство " /></a></div><?php endif; ?>
        <div class="LHeader">
            <a title="туристическое агенство <?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( "/travelAgency/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <a href="<?= SiteHelper::createUrl("/country")."/".$item->country_id->slug ?>.html" title="<?= $item->country_id->name ?>">Страна: <b><?= $item->country_id->name ?></b></a><br/>
            Туров: <b><?= CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams(array(":firm_id"=>$item->id)) ) ?></b><br/>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>