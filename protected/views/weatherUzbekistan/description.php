<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Погода в Узбекистане'=>SiteHelper::createUrl("/weather"),
        $item->name
    )
));
?>
<h1><?= $item->name ?></h1>
<?= $item->description ?>
<div class="textAlignCenter">
    <?php foreach( $list as $item ) :?>
        <div class="WItems WIT2">
            <span><b><?= $item->name ?></b></span>
            <div class="WIImage">
                <?php if( $item->image ) : ?><img src="themes/classic/images/wheter/<?= $item->image ?>" alt="<?= $item->title ?>" /><br/><?php endif; ?>
                <?= $item->title ?>
            </div>
            <div class="WIValue"><?= $item->value1 ? $item->value1 : 0 ?></div>
            <div class="WIValue WIValue2"><?= $item->value2 ? $item->value2 : 0 ?></div>
        </div>
    <?php endforeach; ?>
    <br/><br/>
    <br/><br/>
    <div class="textAlignCenter" style="font-size: 10px;font-style: italic;">Информация предоставленна сервисом Yandex.ru</div>
</div>