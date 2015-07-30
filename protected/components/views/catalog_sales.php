<?php foreach( $items as $item ) :
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/description" )."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров") ?>: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="panel-body">
            <div class="IImage img-rounded">
                <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( $url."/description" )."/".$item->slug .".html", "", 0 ) ?>
            </div>
            <div class="blockquote blockquoteOrange floatRight">
                <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->firm_id->slug ?>.html" title="<?= $item->firm_id->name ?>"><?= Yii::t("page", "Фирма"); ?>: <b><?= $item->firm_id->name ?></b></a><br/>
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