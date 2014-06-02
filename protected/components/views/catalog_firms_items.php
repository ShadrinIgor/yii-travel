<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( $url."/description" )."/".$item->slug .".html" ) ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров") ?>: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
            <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= $item->firm_id->name ?>"><?= Yii::t("page", "Фирма"); ?>: <b><?= $item->firm_id->name ?></b></a><br/>
            <a href="<?= SiteHelper::createUrl("/country")."/".$item->country_id->slug ?>.html" title="<?= $item->country_id->name ?>"><?= Yii::t("page", "Страна"); ?>: <b><?= $item->country_id->name ?></b></a><br/>
            <a href="<?= SiteHelper::createUrl("/tours/description")."/".$item->category_id->slug ?>.html" title="<?= $item->category_id->name ?>">Категория: <b><?= $item->category_id->name ?></b></a><br/>
        </div>
        <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--<?= Yii::t("page", "Список пуст"); ?>--</center>
<?php endif; ?>