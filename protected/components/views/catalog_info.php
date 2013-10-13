<?php
foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><a title="<?= SiteHelper::getTranslateForUrl( $item->name )?>" href="<?= SiteHelper::createUrl( $url."/description", array(  "id"=>$item->id, "slug"=>SiteHelper::getSlug( $item ) )) ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></a></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= SiteHelper::getTranslateForUrl( $item->name )?>" href="<?= SiteHelper::createUrl( $url."/description", array(  "id"=>$item->id, "slug"=>SiteHelper::getSlug( $item ) )) ?>"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <?php if( $item->level > 0 ) : ?><div class="levelStar"><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" alt="" /></div><?php endif;  ?>
            <?php if( $item->category_id ) : ?><a href="<?= SiteHelper::createUrl("info/index", array( "category_id"=>$item->category_id->id, "slug"=>SiteHelper::getSlug( $item->category_id ) )) ?>" title="<?= $item->category_id->name ?>"><b><?= $item->category_id->name ?></b></a><br/><?php endif; ?>
            <?php if( $item->country_id ) : ?><a href="<?= SiteHelper::createUrl("info/index", array( "country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ) )) ?>" title="<?= $item->country_id->name ?>">Страна: <b><?= $item->country_id->name ?></b></a><br/><?php endif; ?>
            <?php if( $item->city_id ) : ?>Город: <b><?= $item->city_id->name ?></b><br/><?php endif; ?>
        </div>
        <?= CCmodelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>