<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Карта Узбекистана'=>SiteHelper::createUrl("/uzbekistanMaps"),
        $item->name
    )
));
?>
<h1><?= $item->name ?></h1>
<?= $item->description ?>
<div class="textAlignCenter">
    <div class="textAlignCenter">
        <a href="<?= $item->file ?>" target="_blank" title="<?= $item->name ?> - в полный размер" style="font-weight: bold;">Смотреть в большом размер</a>
        <br/><br/>
        <a href="<?= $item->file ?>" target="_blank" title="Увеличить - <?= $item->name ?>"><img style="width: 800px;" src="<?= ImageHelper::getImage( $item->image, 1 ) ?>"  title="Увеличить - <?= $item->name ?>" alt="Увеличить - <?= $item->name ?>" /> </a>
        <br/>
        <a href="<?= $item->file ?>" target="_blank" title="<?= $item->name ?> - в полный размер" style="font-weight: bold;">Смотреть в большом размер</a>
    </div>
</div>