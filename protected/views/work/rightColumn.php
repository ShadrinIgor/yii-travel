<div id="Cleft">
    <?php $this->widget("authWidget"); ?>
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
    <?php $this->widget("socialLinksWidget") ?>
    <?php $this->widget("statWidget") ?>
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Курорты"), "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>

    <div id="keywords">
        <?php Yii::app()->page->renderTags( "work" ) ?>
    </div>
</div>