<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Погода в Узбекистане'
    )
));
?>
<h1>Погода в Узбекистане</h1>
<div class="textAlignCenter">
<?php foreach( $list as $item ) :
    $info = CatalogWheters::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "city_id=:id" )->setParams(array(":id"=>$item->city_id->id))->setLimit(1)->setOrderBy("id") );
?>
    <div class="WItems">
        <h2><?= $item->name ?></h2>
        <div class="WIImage">
            <?php if( $info[0]->image ) : ?><img src="themes/classic/images/wheter/<?= $info[0]->image ?>" alt="<?= $info[0]->title ?>" /><br/><?php endif; ?>
            <?= $info[0]->title ?>
        </div>
        <div class="WIValue"><?= $info[0]->value1 ? $info[0]->value1 : 0 ?></div>
        <div class="WIValue WIValue2"><?= $info[0]->value2 ? $info[0]->value2 : 0 ?></div>
        <div class="textAlignCenter"><br/><a href="<?= $item->slug ?>.html" title="<?= $item->name ?>, смотреть подробнее">смотреть подробнее</a></div>
    </div>
<?php endforeach; ?>
<br/>
<br/>
<br/>
<hr/>
<div class="smallFont">погода в узбекистане, погода узбекистан, узбекистан погода</div>
</div>