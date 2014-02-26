<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/", array(  "slug"=>$item->slug)) ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <a href="<?= SiteHelper::createUrl("/travelAgency")."/".$item->firm_id->slug ?>.html" title="<?= $item->firm_id->name ?>">Фирма: <b><?= $item->firm_id->name ?></b></a><br/>
            <a href="<?= SiteHelper::createUrl("/country")."/".$item->country_id->slug ?>.html" title="<?= $item->country_id->name ?>">Страна: <b><?= $item->country_id->name ?></b></a><br/>
            <a href="<?= SiteHelper::createUrl("/tours")."/".$item->category_id->slug ?>.html" title="<?= $item->category_id->name ?>">Категория: <b><?= $item->category_id->name ?></b></a><br/>
        </div>
    </div>
<?php
endforeach;