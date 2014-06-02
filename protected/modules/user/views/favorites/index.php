<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Избранное" ),
    ));
?>
<h1>Избранное</h1>
    <?= $userModel->getMessage();  ?>
    <div class="overflowHidden">
        <?php foreach( $items as $item ) : ?>
            <div class="IBItem IBFavorites">
                <div class="BIImage<?php if( !$item->image ) : ?> noImage<?php endif; ?>"><?php if( $item->image ) : ?><img src="<?= ImageHelper::getImage( $item->image, 2 ); ?>" /><?php endif; ?></div>
                <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
                <div class="IBPrice"><?php if( $item->price>0 ) : ?><div class="IBPrice2"><font>$</font><b><?= $item->price ?></b><div class="itemRightBG"></div></div><?php endif; ?></div>
                <div class="IBDesc"><?= SiteHelper::getSubTextOnWorld( $item->description, 140 ) ?></div>
                <div class="redLink"><a href="<?= SiteHelper::createUrl( "/user/favorites", array( "del"=>$item->id ) ) ?>">удалить</a></div>
            </div>
        <?php endforeach; ?>
        <?php if( sizeof( $items ) == 0 ) : ?>
            <div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div>
        <?php endif; ?>
    </div>
</div>