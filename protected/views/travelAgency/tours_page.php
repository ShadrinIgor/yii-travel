<div id="firmTours">
    <?php if( $this->beginCache( "firmDescriptionTours-".$item->id."_".Yii::app()->getLanguage(), array('duration'=> SiteHelper::getConfig( "firmDescriptionTours" ) ) ) ) : ?>
        <div class="row">
            <?php
                // Категории
                $listCategory = CatalogToursCategory::sql( "SELECT id, owner FROM `catalog_tours_category` WHERE owner>0 AND id IN( SELECT category_id FROM catalog_tours WHERE firm_id=".$item->id." AND del=0  AND active=1 )" );
                $reCategory = array();
                $reCategory2 = array();

                // Раскладываем по OWNER-у
                foreach( $listCategory as $category )
                {
                    $reCategory[ $category["owner"] ][] =  $category["id"];
                }

                // Подменяем ID на обект и подсчитываем количество
                foreach( $reCategory as $category=>$value )
                {
                    $ownerCategoryModel = CatalogToursCategory::fetch( $category );
                    $array = array();
                    foreach( $value as $cid )
                    {
                        if( $cid>0 )
                        {
                            $obj = CatalogToursCategory::fetch($cid);
                            $array[] = $obj;
                        }
                    }
                    $reCategory2[ $ownerCategoryModel->name ] = $array;
                }

                // Странны
                $listCountry = CatalogCountry::sql( "SELECT id FROM `catalog_country` WHERE id IN( SELECT country_id FROM catalog_tours WHERE firm_id=".$item->id." AND del=0 AND active=1 )" );

                $reCountry2 = array();
                // Подменяем ID на обект и подсчитываем количество
                foreach( $listCountry as $id=>$keys )
                {
                    if( $keys["id"] >0 )
                    {
                        $obj = CatalogCountry::fetch( $keys["id"] );
                        if( $obj->id >0 )$reCountry2[] = $obj;
                    }
                }
            ?>

            <div class="col-xs-6">
                <div class="panel panel-success">
                    <div class="panel-heading"><?= Yii::t("page", "Категории туров"); ?></div>
                    <div class="panel-body">
                        <ul>
                            <?php foreach( $reCategory2 as $cItem=>$values ) : ?>
                                <li>
                                    <b><?= $cItem ?></b>
                                    <ul>
                                        <?php foreach( $values as $cKey=>$cValue ) : ?>
                                            <li><a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html?category=<?= $cValue->slug ?>&tab=tours" title="<?= Yii::t("page", "категория туров"); ?> - <?= $cValue->name ?> "><?= $cValue->name ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="panel panel-warning">
                    <div class="panel-heading"><?= Yii::t("page", "Туры по странам"); ?></div>
                    <div class="panel-body">
                        <ul>
                            <?php foreach( $reCountry2 as $cItem=>$values ) : ?>
                                <li><a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html?country=<?= $values->slug ?>&tab=tours" title="<?= Yii::t("page", "туры"); ?> <?= $values->name_2 ?>"><?= $values->name ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php $this->endCache();endif; ?>

    <h2><?= Yii::t("user_firm", "Туры компании"); ?>
        <?php if( !empty( $categoryModel ) && $categoryModel->id >0 ) : ?>
            , в категории <?= $categoryModel->name ?>
        <?php endif; ?>
        <?php if( !empty( $countryModel ) && $countryModel->id >0 ) : ?>
           , по стране <?= $countryModel->name ?>
        <?php endif; ?>
    </h2>
    <div id="catalogItems">
        <?php $controller->widget("tour2Widget", array("items"=>$items, "url"=>"tours") ) ?>
    </div>
</div>