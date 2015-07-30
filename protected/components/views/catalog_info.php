<?php
foreach( $items as $item ) :
    ?>
    <div class="panel panel-default">

        <div class="panel-heading">
            <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/touristInfo/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="IImage img-rounded"><?= Yii::t("page", "просмотров") ?>: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="panel-body">
            <div class="IImage img-rounded">
                <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/touristInfo/description")."/".$item->slug.".html", "", 0  ) ?>
            </div>
            <div class="blockquote blockquoteOrange floatRight width200">
                <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                <?php if( $item->level > 0 ) : ?><div class="levelStar"><img src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" alt="" /></div><?php endif;  ?>
                <?php if( $item->category_id ) : ?><a href="<?= SiteHelper::createUrl("/touristInfo", array( "category"=>$item->category_id->slug )) ?>.html" title="<?= $item->category_id->name ?>"><b><?= $item->category_id->name ?></b></a><br/><?php endif; ?>
                <?php if( $item->country_id->id>0 ) : ?><a href="<?= SiteHelper::createUrl("/touristInfo", array( "country"=>$item->country_id->slug )) ?>.html" title="<?= $item->country_id->name ?>"><?= Yii::t("page", "Страна"); ?>: <b><?= $item->country_id->name ?></b></a><br/><?php endif; ?>
                <?php if( $item->city_id->id>0 ) : ?><?= Yii::t("page", "Город"); ?>: <b><?= $item->city_id->name ?></b><br/><?php endif; ?>
                <br/>
                <a class="label" href="<?= SiteHelper::createUrl( "/touristInfo/description" )."/".$item->slug ?>.html" title="<?= $item->name ?>">подробнее....</a>
            </div>
            <div class="well well-lg"><div class="limitText">
                <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
            </div></div>
        </div>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--<?= Yii::t("page", "Список пуст"); ?>--</center>
<?php endif; ?>