<div id="Cleft">
    <?php $this->widget("authWidget"); ?>
    <div class="LeftMenu">
        <h3>Категории</h3>
        <?php if( $this->beginCache( "info_category", array('duration'=>3600) ) ) : ?>
        <ul>
            <?php
            foreach( CatalogInfoCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setConditions("owner=0") ) as $item_ ) :
            $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item_->id))->setLimit(-1) );
            ?>
            <li><a href="<?= SiteHelper::createUrl("/touristInfo", array("category"=>$item_->slug)) ?>.html" title="<?= $item_->name ?> информация для туристов"><?= $item_->name ?> ( <?= $count ?> )</a>
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

    <div class="LeftMenu">
        <h3>Информация по странам</h3>
        <?php if( $this->beginCache( "info_country", array('duration'=>3600) ) ) : ?>
            <ul>
                <?php
                foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) :
                    $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country")->setParams(array(":country"=>$item->id))->setLimit(-1) );
                    if( $count > 0 ) :
                    ?>
                    <li><a href="<?= SiteHelper::createUrl("/touristInfo", array("country"=>$item->slug)) ?>.html" title="тур. информация <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
                <?php
                    endif;
                endforeach; ?>
            </ul>
            <?php $this->endCache(); endif;?>
    </div>

    <div id="keywords">
        <hr/>
        <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <h3>тур фирмы</h3> <b>отдых</b> <b>туризм 2010</b> <font>путешествия по узбекистану</font> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>