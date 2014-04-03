<div id="Cleft">
    <?php $this->widget("authWidget"); ?>

    <div class="BIBlock LeftMenu">
        <?php if( $this->beginCache( "umor", array('duration'=>3600) ) ) : ?>
        <div class="BITItems">
            <?php
                $umor = CatalogUmor::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("rand()")->setLimit(3) );
                foreach( $umor as $item ) :
            ?>
                <p><?= $item->description ?></p>
            <?php endforeach; ?>
        </div>
        <?php $this->endCache();endif; ?>
        <a href="fany/" class="mLinks" title="весь юмор">весь юмор...</a>
        <br/>
    </div>

    <?php $this->widget("socialLinksWidget") ?>

    <?php if( $this->beginCache( "site_counts", array('duration'=>3600) ) ) : ?>
    <div id="RStatistic">
        <ul>
            <li><b>На сайте:</b></li>
            <li>туристических стран: <u><?= CatalogCountry::count() ?></u></li>
            <li>туров: <u><?= CatalogTours::count() ?></u></li>
            <li>курортов: <u><?= CatalogKurorts::count() ?></u></li>
            <li>гостиниц: <u><?= CatalogHotels::count() ?></u></li>
            <li>туристических фирм: <u><?= CatalogFirms::count() ?></u></li>
            <li>статей о туризме: <u><?= CatalogInfoCategory::count() ?></u></li>
            <!--    <li>частных объявлений: <u>45</u></li>
            -->
        </ul>
    </div>
    <?php $this->endCache();endif; ?>

    <div class="LeftMenu">
    </div>

    <?php $this->widget("infoWidget", array( "title"=>"Курорты", "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>

    <div id="keywords">
        <hr/>
        <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <h3>тур фирмы</h3> <b>отдых</b> <b>туризм 2010</b> <font>путешествия по узбекистану</font> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>