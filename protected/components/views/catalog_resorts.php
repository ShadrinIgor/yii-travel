<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><a title="<?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( "/resorts/description")."/".$item->slug ?>.html"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( "/resorts/description")."/".$item->slug ?>.html" href="<?= SiteHelper::createUrl( "/resorts/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <?php if( $item->level > 0 ) : ?><div class="levelStar"><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" alt="" /></div><?php endif;  ?>
            <a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item->category_id->slug ?>.html" title="курорты <?= $item->category_id->name ?>"><b><?= $item->category_id->name ?></b></a><br/>
            Страна: <b><?= $item->country_id->name ?></b><br/>
            <?php if( $item->city_id ) : ?>Город: <b><?= $item->city_id->name ?></b><br/><?php endif; ?>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>