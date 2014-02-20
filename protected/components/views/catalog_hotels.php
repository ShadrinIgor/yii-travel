<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( "/hotels/description")."/".$item->slug ?>.html"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></a></a></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( "/hotels/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <?php if( $item->level > 0 ) : ?><div class="levelStar"><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" alt="" /></div><?php endif;  ?>
            Страна: <a href="<?= SiteHelper::createUrl("/hotels/country")."/".$item->country_id->slug  ?>.html" title="<?= $item->country_id->name ?>"><b><?= $item->country_id->name ?></b></a><br/>
            Город: <a href="<?= SiteHelper::createUrl("/hotels/city")."/".$item->city_id->slug  ?>.html" title="<?= $item->city_id->name ?>"><b><?= $item->city_id->name ?></b></a><br/>
        </div>
        <?= CCmodelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>