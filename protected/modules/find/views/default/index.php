<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "поиск"
    ),
));

?>
<div id="catalogItems">
    <h2>Поиск</h2>

<?php if( sizeof( $arrayData ) ) : ?>
    <div id="categoryBlock">
    <?php foreach( $arrayData as $key=>$cid ) : ?>
        <div class="CBItems">
            <div class="CBHeader"><?= $key ?> <font>( <?= $cid["count"] ?> )</font></div>
            <?php foreach( $cid["items"] as $key2=>$value2 ) : ?>
                <ul>
                    <li><?= $value2["name"] ?> <font>( <?= $value2["c"] ?> )</font></li>
                </ul>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php foreach( $items as $item ) : ?>
    <div class="CItem">
        <div class="BIImage<?php if( !$item->image ) : ?> noImage<?php endif; ?>"><?php if( $item->image ) : ?><img src="<?= ImageHelper::getImage( $item->image, 2 ); ?>" /><?php endif; ?></div>
        <div class="floatRight ItemPrice"><?php if( $item->price>0 ) : ?><b><?= $item->price ?></b> <font>тг.</font><?php endif; ?></div>
        <div class="floatRight ItemDate"><?php if( $item->date>0 ) : ?><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><?php endif; ?></div>
        <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
        <?= SiteHelper::getSubTextOnWorld( $item->description, 500 ) ?>
        <div class="textAlignRight">
            <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" titile="">подробнее...</a>
        </div>
    </div>
<?php endforeach; ?>
<?php if( sizeof( $items ) == 0 ) : ?><div class="textAlignCenter">Записей не найденно</div><?php endif; ?>
</div>