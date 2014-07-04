<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/resorts/description")."/".$item->slug.".html", $item->name." - ".Yii::t("page", "курорты")." ". $item->category_id->name2 ) ?>
        <div class="LHeader">
            <a title="<?= SiteHelper::getStringForTitle( $item->name ) ?>" href="<?= SiteHelper::createUrl( "/resorts/description")."/".$item->slug ?>.html" href="<?= SiteHelper::createUrl( "/resorts/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <?php if( $item->level > 0 ) : ?><div class="levelStar"><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" alt="" /></div><?php endif;  ?>
            <a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item->category_id->slug ?>.html" title="<?= Yii::t("page", "курорты") ?> - <?= $item->category_id->name ?> Узбекистана"><b><?= $item->category_id->name ?></b></a><br/>
            <?= Yii::t("page", "Страна"); ?>: <b><?= $item->country_id->name ?></b><br/>
            <?php if( $item->city_id->id>0 ) : ?><?= Yii::t("page", "Город"); ?>: <b><?= $item->city_id->name ?></b><br/><?php endif; ?>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--<?= Yii::t("page", "Список пуст"); ?>--</center>
<?php endif; ?>