
<?php if( $this->beginCache( "site_counts"."_".Yii::app()->getLanguage(), array('duration'=>3600*24) ) ) : ?>
    <div id="RStatistic">
        <ul>
            <li><b><?= Yii::t("page", "На сайте"); ?>:</b></li>
            <li><?= Yii::t("page", "туристических стран"); ?>: <u><?= CatalogCountry::count() ?></u></li>
            <li><?= Yii::t("page", "туров"); ?>: <u><?= CatalogTours::count() ?></u></li>
            <li><?= Yii::t("page", "курортов"); ?>: <u><?= CatalogKurorts::count() ?></u></li>
            <li><?= Yii::t("page", "гостиниц"); ?>: <u><?= CatalogHotels::count() ?></u></li>
            <li><?= Yii::t("page", "туристических фирм"); ?>: <u><?= CatalogFirms::count() ?></u></li>
            <li><?= Yii::t("page", "статей о туризме"); ?>: <u><?= CatalogInfoCategory::count() ?></u></li>
            <!--    <li>частных объявлений: <u>45</u></li>
            -->
        </ul>
    </div>
<?php $this->endCache();endif; ?>