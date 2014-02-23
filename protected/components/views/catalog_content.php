<?php foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( "/news/description")."/".$item->slug ?>.html"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></a></a></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( "/news/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <?= CCmodelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>