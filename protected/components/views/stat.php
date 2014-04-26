
<?php if( $this->beginCache( "site_counts", array('duration'=>3600*24) ) ) : ?>
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