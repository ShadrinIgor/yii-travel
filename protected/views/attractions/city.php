<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'достопримечательности Узбекистана' => SiteHelper::createUrl("/attractions"),
        'достопримечательности '.$city->name2
    )
));
?>
<h1>Достопримечательности <?= $city->name2 ?></h1>
<div class="textAlignCenter">
    <div class="overflowHidden">
        <?php foreach( CatalogAttractions::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("city_id=:id")->setParams( array(":id"=>$city->id) )->setLimit(-1)->setOrderBy("id DESC") ) as $item ) : ?>
            <div class="ATTtems">
                <div class="WIImage">
                    <a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" /></a><br/>
                </div>
                <div class="overflowHidden">
                    <br/>
                    <a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
                    <?= SiteHelper::getSubTextOnWorld( $item->description, 500 ) ?>
                </div>
                <div class="textAlignRight"><a href="<?= SiteHelper::createUrl( "/attractions" ) ."/".$item->slug ?>.html" title="смотреть подробнее">смотреть подробнее</a></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>