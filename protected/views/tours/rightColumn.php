<div id="Cleft">
    <?php $this->widget("authWidget"); ?>

    <div class="LeftMenu">
        <h3><?= Yii::t("page", "Категории туров"); ?></h3>
        <?php if( $this->beginCache( "tours_category"."_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
        <ul>
            <?php
            foreach( CatalogToursCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setConditions("owner=0") ) as $item_ ) :
            $count = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item_->id))->setLimit(-1) );
            ?>
            <li><a href="<?= SiteHelper::createUrl("/tours/category")."/".$item_->slug ?>" title="<?= Yii::t("page", "категория туров"); ?> - <?= $item_->name ?> <?= Yii::t("page", "туры"); ?>"><?= $item_->name ?> ( <?= $count ?> )</a>
                <ul>
                <?php
                foreach( CatalogToursCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setConditions("owner=:owner")->setParams(array(":owner"=>$item_->id))->setLimit(-1) ) as $item ) :
                    $count = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item->id))->setLimit(-1) );
            ?>

                    <?php if( $count>0 ) : ?><li><a href="<?= SiteHelper::createUrl("/tours/category")."/".$item->slug ?>.html" title="<?= Yii::t("page", "категория туров"); ?> - <?= $item->name ?> <?= Yii::t("page", "туры"); ?>"><?= $item->name ?> ( <?= $count ?> )</a></li><?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php $this->endCache(); endif;?>
    </div>

    <div class="LeftMenu">
        <h3><?= Yii::t("page", "Туры по странам"); ?></h3>
        <?php if( $this->beginCache( "tours_country", array('duration'=>3600) ) ) : ?>
            <ul>
                <?php
                foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) :
                    $count = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country")->setParams(array(":country"=>$item->id))->setLimit(-1) );
                    ?>
                    <li><a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->slug ?>.html" title="<?= Yii::t("page", "туры"); ?> <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
                <?php endforeach; ?>
            </ul>
            <?php $this->endCache(); endif;?>
    </div>

    <div id="keywords">
        <?php Yii::app()->page->renderTags( "tours" ) ?>
    </div>
</div>