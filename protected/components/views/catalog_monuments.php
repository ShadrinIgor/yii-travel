<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( $url."/description" )."/".$item->slug .".html" ) ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html"><?= $item->name ?></a>
        </div>
        <div class="LParams">
            <a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->country_id->slug ?>.html" title="<?= $item->country_id->name ?>"><?= Yii::t("page", "Страна"); ?>: <b><?= $item->country_id->name ?></b></a><br/>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--<?= Yii::t("page", "Список пуст"); ?>--</center>
<?php endif; ?>