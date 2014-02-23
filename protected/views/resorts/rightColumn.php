<div id="Cleft">
    <div class="LeftMenu">
        <h3>Категории</h3>
        <?php if( $this->beginCache( "resorts_category", array('duration'=>3600) ) ) : ?>
        <ul>
            <?php 
            foreach( CatalogKurortsCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setConditions("owner=0") ) as $item_ ) :
            $count = CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item_->id))->setLimit(-1) );
            ?>
            <li><a href="<?= SiteHelper::createUrl("/resorts/category")."/".$item_->slug ?>.html" title="<?= $item_->name ?> зоны отдыха"><?= $item_->name ?> ( <?= $count ?> )</a>
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

    <?php $this->widget("infoWidget", array( "title"=>"Отели", "class"=>"CatalogHotels", "link"=>"/hotels" )); ?>

    <div id="keywords">
        <hr/>
        <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <h3>тур фирмы</h3> <b>отдых</b> <b>туризм 2010</b> <font>путешествия по узбекистану</font> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>