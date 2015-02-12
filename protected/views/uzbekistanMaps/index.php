<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Карта Узбекистана'
    )
));
?>
<h1>Карта Узбекистана</h1>
<div class="textAlignCenter">
<?php foreach( $list as $item ) : ?>
    <div class="WItems MIMaps">
        <h2><?= $item->name ?></h2>
        <div class="WIImage">
            <a href="<?= $item->slug ?>.html" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><br/>
        </div>
        <div class="textAlignCenter"><a href="<?= $item->slug ?>.html" title="<?= $item->name ?>,смотреть подробнее">смотреть подробнее</a></div>
    </div>
<?php endforeach; ?>
<br/>
<br/>
<br/>
<hr/>
<div class="smallFont">карта Узбекистана, карта Узбекистан, Узбекистан карта, Uzbekistan map</div>
</div>