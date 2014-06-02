<div id="Cleft">
    <?php $this->widget("authWidget"); ?>

    <div class="LeftMenu">
        <h3><?= Yii::t("page", "Разделение по городам"); ?></h3>
        <?php if( $this->beginCache( "hotels_city", array('duration'=>3600) ) ) : ?>
            <ul>
                <?php
                foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $citem ) :
                    $clitCity = CatalogCity::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams( array( ":country_id"=>$citem->id ) )->setOrderBy( "name" )->setLimit(-1) );
                ?>
                    <?php if( sizeof($clitCity)>0 ) : ?>
                    <li><a href="<?= SiteHelper::createUrl("/hotels/country")."/".$citem->slug ?>.html" title="<?= Yii::t("page", "отели"); ?> <?= $citem->name_2 ?>"><?= $citem->name ?></a>
                        <ul>
                        <?php foreach( $clitCity as $item ) :
                            $count = CatalogHotels::count( DBQueryParamsClass::CreateParams()->setConditions("city_id=:city_id")->setParams(array(":city_id"=>$item->id))->setLimit(-1) );
                            if( $count==0 )continue;
                            ?>
                            <li><a href="<?= SiteHelper::createUrl("/hotels/city")."/".$item->slug ?>.html" title="<?= Yii::t("page", "туры") ?> <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
                        <?php
                        endforeach; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                <?php endforeach;
                ?>
            </ul>
            <?php $this->endCache(); endif;?>
    </div>

    <div id="keywords">
        <?php Yii::app()->page->renderTags( "hotels" ) ?>
    </div>
</div>