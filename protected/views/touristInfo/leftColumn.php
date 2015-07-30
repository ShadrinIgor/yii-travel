<div class="leftBlock">
    <div id="LeftBG">
        <h3><?= Yii::t("page", "Категории"); ?></h3>
        <?php if( $this->beginCache( "info_category"."_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
        <ul>
            <?php
            foreach( CatalogInfoCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setConditions("owner=0") ) as $item_ ) :
                $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item_->id))->setLimit(-1) );
                ?>
                <li><a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item_->slug)) ?>.html" title="<?= $item_->name ?> <?= Yii::t("page", "информация для туристов"); ?>"><?= $item_->name ?> ( <?= $count ?> )</a>
                    <ul>
                        <?php
                        foreach( CatalogInfoCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setConditions("owner=:owner")->setParams(array(":owner"=>$item_->id))->setLimit(-1) ) as $item ) :
                            $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item->id))->setLimit(-1) );
                            ?>

                            <?php if( $count>0 ) : ?><li><a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item->slug)) ?>.html" title="<?= $item->name ?>"><?= $item->name ?> ( <?= $count ?> )</a></li><?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php $this->endCache(); endif;?>
    </div>
    <div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "left" ) ?></div>
    <?php $this->widget("authWidget"); ?>
</div>


