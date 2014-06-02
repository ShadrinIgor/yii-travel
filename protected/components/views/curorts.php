<div class="IILeft">
    <?php
    $i=1;
    $step = 1;
    foreach( $list as $item ) :

        if(  $step!=3 && !$item->image ) continue;
        if( $i == 4 )$step=2;
        if( $i == 8 )$step=3;

        $i++;
        ?>
        <div class="ILItems">
            <?php if( $step != 2 ) : ?><a href="<?= SiteHelper::createUrl( "/info/description", array("id"=>$item->id) ) ?>" title="<?= $item->name ?>" class="ILIHed"><?= $item->name ?></a><?php endif; ?>
            <?php if( $step != 3 && $item->image ) : ?><div class="LI<?= $step==1 ? " ISize1" : " ImageLimit" ?>"><a href="<?= SiteHelper::createUrl( "/info/description", array("id"=>$item->id) ) ?>" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a></div><?php endif; ?>
            <?php if( $step == 2 ) : ?><a href="<?= SiteHelper::createUrl( "/info/description", array("id"=>$item->id) ) ?>" title="<?= $item->name ?>" class="ILIHed"><?= $item->name ?></a><?php endif; ?>
            <?= $step==2 ? SiteHelper::getSubTextOnWorld( $item->name, 200 ) : "" ?>
            <?= $step==3 ? SiteHelper::getSubTextOnWorld( $item->name, 100 ) : "" ?>
        </div>
    <?php endforeach; ?>
    <a title="остальные" class="mLinks" href="info/"><?= Yii::t("page", "остальные"); ?> ...</a>
</div>