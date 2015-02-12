<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'Достопримечательности Узбекистана'
    )
));
?>
<h1>Достопримечательности Узбекистана</h1>
<div class="textAlignCenter">
<?php foreach( $city as $citem ) :
    $list = CatalogAttractions::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("city_id=:id")->setParams( array(":id"=>$citem->id) )->setLimit(2)->setOrderBy("id DESC") );
?>
    <?php if( sizeof($list)>0 ) : ?>
        <div class="overflowHidden">
            <br/>
            <h2><?= $citem->name ?></h2>
            <?php foreach( $list as $item ) : ?>
                <div class="ATTtems">
                    <div class="WIImage">
                        <a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><br/>
                    </div>
                    <div class="overflowHidden">
                        <br/>
                        <a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
                        <?= SiteHelper::getSubTextOnWorld( $item->description, 500 ) ?>
                    </div>
                    <div class="textAlignRight"><a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $item->name ?>,смотреть подробнее">смотреть подробнее</a></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
</div>