<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Погода в Узбекистане'=>SiteHelper::createUrl("/weatherUzbekistan"),
        $item->name
    )
));
?>
<h1><?= $item->name ?></h1>
<div class="textAlignCenter WeatherBlock WeatherBlock2">
    <?php foreach( $list as $item2 ) :?>
        <div class="WItems WIT2">
            <span><b><?= $item2->name ?></b></span>
            <div class="WIImage">
                <?php if( $item2->image ) : ?><img src="themes/classic/images/wheter/<?= $item2->image ?>" alt="<?= $item2->title ?>" /><br/><?php endif; ?>
                <?= $item2->title ?>
            </div>
            <div class="WIValue"><?= $item2->value1 ? $item2->value1 : 0 ?></div>
            <div class="WIValue WIValue2"><?= $item2->value2 ? $item2->value2 : 0 ?></div>
        </div>
    <?php endforeach; ?>
    <br/><hr/>
    <div class="textAlignJustify">
        <?= $item->description ?>
    </div>
    <br/><br/>
    <div class="textAlignCenter" style="font-size: 10px;font-style: italic;">Информация предоставленна сервисом Yandex.ru</div>
</div>