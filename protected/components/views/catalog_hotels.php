<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/hotels/description")."/".$item->slug.".html", $item->name." - отели ".$item->country_id->name2 ) ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( "/hotels/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров") ?>: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <?php if( $item->level > 0 ) : ?><div class="levelStar"><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" alt="" /></div><?php endif;  ?>
            Страна: <a href="<?= SiteHelper::createUrl("/hotels/country")."/".$item->country_id->slug  ?>.html" title="<?= $item->country_id->name ?>"><b><?= $item->country_id->name ?></b></a><br/>
            Город: <a href="<?= SiteHelper::createUrl("/hotels/city")."/".$item->city_id->slug  ?>.html" title="<?= $item->city_id->name ?>"><b><?= $item->city_id->name ?></b></a><br/>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Yii::t("page", "Список пуст") ); ---</center>
<?php endif; ?>