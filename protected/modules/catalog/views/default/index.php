<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "каталог"
    ),
));

?>
<div id="catalogItems">
    <h2>Каталог <?= $category->name ?></h2>
<?php foreach( $items as $item ) : ?>
    <div class="CItem">
        <div class="BIImage<?php if( !$item->image ) : ?> noImage<?php endif; ?>"><?php if( $item->image ) : ?><img src="<?= ImageHelper::getImage( $item->image, 2 ); ?>" /><?php endif; ?></div>
        <div class="floatRight ItemPrice"><?php if( $item->price>0 ) : ?><b><?= $item->price ?></b> <font>тг.</font><?php endif; ?></div>
        <div class="floatRight ItemDate"><?php if( $item->date>0 ) : ?><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><?php endif; ?></div>
        <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
        <i><?= Yii::t("page", "Категория"); ?>: <?= $item->category_id->name ?></i><br/>
        <?= SiteHelper::getSubTextOnWorld( $item->description, 500 ) ?>
        <div class="textAlignRight">
            <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" titile="">подробнее...</a>
        </div>
    </div>
<?php endforeach; ?>
<?php if( sizeof( $items )==0 ) : ?>
    <div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div>
<?php  endif; ?>
</div>