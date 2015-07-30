<div class="row tourItems">
    <?php foreach( $items as $item ) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="label label-success label-big"><?= $item->country_id->name ?></span>&nbsp;<a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html"><?= $item->name ?></a>
            <div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div>
        </div>
        <div class="panel-body">
            <div class="IImage img-rounded">
                <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( $url."/description" )."/".$item->slug .".html", "", 0 ) ?>
            </div>
            <div class="blockquote blockquoteOrange floatRight width200 height146">
                <?php if( $item->price > 0 ) : ?><div class="overflowHidden"><span class="label label-info"><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?><?= $item->currency_id && $item->currency_id->id >0 ? $item->currency_id->title : "$" ?></b></span></div><br/><?php else: ?><br/><?php endif; ?>
                <?php if( $item->duration ) : ?><b><?= $item->duration ?></b><br/><?php else: ?><br/><?php endif; ?>
                <a class="clip" href="<?= SiteHelper::createUrl("/tours/category")."/".$item->category_id->slug ?>.html" title="<?= $item->category_id->name ?>"><b><?= $item->category_id->name ?></b></a>
                <!--a class="clip" href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= $item->firm_id->name ?>"><?= Yii::t("page", "Фирма"); ?>: <b><?= $item->firm_id->name ?></b></a-->
                <br/>
                <a class="label" href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html" title="<?= $item->name ?>">подробнее....</a>
            </div>
            <div class="well well-lg"><div class="limitText">
                    <?= CCModelHelper::getLimitText( $item->description, "200" ) ?>
                </div>
            </div>
        </div>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--<?= Yii::t("page", "Список пуст"); ?>--</center>
<?php endif; ?>
</div>