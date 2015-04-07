<div id="Cleft">
    <div class="LeftMenu">
        <h3><?= Yii::t("page", "Туры по странам"); ?></h3>
        <?php if( $this->beginCache( "tours_country_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
            <ul>
                <?php
                foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) :
                    $count = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country")->setParams(array(":country"=>$item->id))->setLimit(-1) );
                    ?>
                    <li><a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->slug ?>.html" title="<?= Yii::t("page", "туры"); ?> <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
                <?php endforeach; ?>
            </ul>
            <?php $this->endCache(); endif;?>
        <br/>
    </div>
    <?php $this->widget("authWidget"); ?>
    <div id="keywords">
        <?php Yii::app()->page->renderTags( "tours" ) ?>
    </div>
</div>