<div class="leftBlock">
    <?php $this->widget("authWidget"); ?>
    <?php $this->widget("findFormWidget") ?>
    <div id="LeftBG">
        <div class="LeftMenu">
            <h3><?= Yii::t("page", "Категории" ) ?></h3>
            <?php if( $this->beginCache( "resorts_category"."_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
                <ul>
                    <?php
                    foreach( CatalogKurortsCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setConditions("owner=0") ) as $item_ ) :
                        $count = CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item_->id))->setLimit(-1) );
                        ?>
                        <li><a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item_->slug ?>.html" title="<?= $item_->name ?> <?= Yii::t("page", "зоны отдыха" ); ?>"><?= $item_->name ?> ( <?= $count ?> )</a>
                            <ul>
                                <?php
                                foreach( CatalogKurortsCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setConditions("owner=:owner")->setParams(array(":owner"=>$item_->id))->setLimit(-1) ) as $item ) :
                                    $count = CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item->id))->setLimit(-1) );
                                    ?>

                                    <?php if( $count>0 ) : ?><li><a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item->slug ?>.html" title="<?= $item->name ?>"><?= $item->name ?> ( <?= $count ?> )</a></li><?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php $this->endCache(); endif;?>
        </div>
        <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
    </div>
    <?php $this->widget("authWidget"); ?>
</div>