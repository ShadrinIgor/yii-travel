<div id="Cleft">
    <?php $this->widget("authWidget"); ?>

    <div class="LeftMenu">
        <h3>Разделение по городам</h3>
        <?php if( $this->beginCache( "hotels_city", array('duration'=>3600) ) ) : ?>
            <ul>
                <?php
                foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $citem ) :
                    $clitCity = CatalogCity::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams( array( ":country_id"=>$citem->id ) )->setOrderBy( "name" )->setLimit(-1) );
                ?>
                    <?php if( sizeof($clitCity)>0 ) : ?>
                    <li><a href="<?= SiteHelper::createUrl("/hotels/country")."/".$citem->slug ?>.html" title="оптели <?= $citem->name_2 ?>"><?= $citem->name ?></a>
                        <ul>
                        <?php foreach( $clitCity as $item ) :
                            $count = CatalogHotels::count( DBQueryParamsClass::CreateParams()->setConditions("city_id=:city_id")->setParams(array(":city_id"=>$item->id))->setLimit(-1) );
                            if( $count==0 )continue;
                            ?>
                            <li><a href="<?= SiteHelper::createUrl("/hotels/city")."/".$item->slug ?>.html" title="туры <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
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
        <hr/>
        <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <h3>тур фирмы</h3> <b>отдых</b> <b>туризм 2010</b> <font>путешествия по узбекистану</font> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>