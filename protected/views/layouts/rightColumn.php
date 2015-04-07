<div id="Cleft">

    <div class="BIBlock LeftMenu">
        <?php if( $this->beginCache( "umor"."_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
        <div class="BITItems">
            <?php
                $umor = CatalogUmor::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("rand()")->setLimit(3) );
                foreach( $umor as $item ) :
            ?>
                <p><?= $item->description ?></p>
            <?php endforeach; ?>
        </div>
        <?php $this->endCache();endif; ?>
        <!--a href="fany/" class="mLinks" title="весь юмор">весь юмор...</a-->
        <br/>
    </div>
    <div class="lBanner"><?= Yii::app()->banners->getBannerByCategory( "right" ) ?></div>
    <?php $this->widget("socialLinksWidget") ?>
    <?php $this->widget("statWidget") ?>
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Курорты"), "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>

    <div id="keywords">
        <?php Yii::app()->page->renderTags( "first_page" ) ?>
    </div>
</div>