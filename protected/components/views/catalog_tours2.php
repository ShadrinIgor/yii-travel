<div class="row">
    <?php foreach( $items as $item ) :
        ?>
        <div class="col-md-6">
            <div class="listItems LI2 well">
                <div class="bg-info">
                    <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html"><?= $item->name ?></a>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-5 col-lg-4 LI"">
                        <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( $url."/description" )."/".$item->slug .".html", "", 0 ) ?>
                    </div>
                    <div class="LParams col-xs-7 col-sm-3 col-md-6 col-lg-3">
                        <?php if( $item->price > 0 ) : ?><span><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?><?= $item->currency_id && $item->currency_id->id >0 ? $item->currency_id->title : "$" ?></b></span><?php endif; ?>
                        <?php if( $item->duration ) : ?><b><?= $item->duration ?></b><br/><?php endif; ?>
                        <a class="clip" href="<?= SiteHelper::createUrl("/tours/category")."/".$item->category_id->slug ?>.html" title="<?= $item->category_id->name ?>"><b><?= $item->category_id->name ?></b></a>
                        <a class="clip" href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= $item->firm_id->name ?>"><?= Yii::t("page", "Фирма"); ?>: <b><?= $item->firm_id->name ?></b></a>
                        <br/>
                        <div class="floatRight textAlignRight"><a href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html" title="<?= $item->name ?>">подробнее....</a></div>
                    </div>
                    <div class="LDesc visible-sm visible-lg hidden-xs hidden-md"><?= CCModelHelper::getLimitText( $item->description, "200" ) ?></div>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
        <center>--<?= Yii::t("page", "Список пуст"); ?>--</center>
    <?php endif; ?>
</div>