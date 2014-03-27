<div id="firmTours">
    <?php if( $this->beginCache( "firmDescriptionTours-".$item->id, array('duration'=>3600) ) ) : ?>
        <div id="CIHeader" class="overflowHidden">
            <?php
                // Категории
                $listCategory = CatalogToursCategory::sql( "SELECT id, owner FROM `catalog_tours_category` WHERE owner>0 AND id IN( SELECT category_id FROM catalog_tours WHERE firm_id=96 AND del=0  AND active=1 )" );
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
                $listCountry = CatalogCountry::sql( "SELECT id FROM `catalog_country` WHERE id IN( SELECT country_id FROM catalog_tours WHERE firm_id=96 AND del=0 AND active=1 )" );

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

            <div class="CICategory">
                <div class="CICLabel">Категории туров</div>
                <div class="CICategoryScrool">
                <ul>
                    <?php foreach( $reCategory2 as $cItem=>$values ) : ?>
                        <li>
                            <b><?= $cItem ?></b>
                            <ul>
                                <?php foreach( $values as $cKey=>$cValue ) : ?>
                                    <li><a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html?category=<?= $cValue->slug ?>&tab=tours" title="категория туров - <?= $cValue->name ?> "><?= $cValue->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                </div>
            </div>
            <div class="CICategory">
                <div class="CICLabel CLRight">Туры по странам</div>
                <div class="CICategoryScrool">
                <ul>
                    <?php foreach( $reCountry2 as $cItem=>$values ) : ?>
                        <li><a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$item->slug ?>.html?country=<?= $values->slug ?>&tab=tours" title="туры <?= $values->name_2 ?>"><?= $values->name ?></a></li>
                    <?php endforeach; ?>
                </ul>
                </div>
            </div>
        </div>
    <?php $this->endCache();endif; ?>

    <h2>Туры компании
        <?php if( !empty( $categoryModel ) && $categoryModel->id >0 ) : ?>
            , в категории <?= $categoryModel->name ?>
        <?php endif; ?>
        <?php if( !empty( $countryModel ) && $countryModel->id >0 ) : ?>
           , по стране <?= $countryModel->name ?>
        <?php endif; ?>
    </h2>
    <table id="tableListItems" cellpadding="0" cellspacing="0">
        <tr>
            <th class="TLFId">№</th>
            <th class="">Фото</th>
            <th class="TLFName" style="width: 150px;">Заголовок</th>
            <th class="TLFAction">Краткое описание</th>
        </tr>
        <?php

        foreach( $items as $tour ): ?>
            <tr <?= $tour->hot==1 ? 'class="isHot"' : "" ?>>
                <td><?= $tour->id ?></td>
                <td>
                    <?php
                    if( !$tour->image )$countImages = 5;
                    else $countImages = 4;

                    $listImages = ImageHelper::getImages( $tour, $countImages );
                    if( sizeof( $listImages ) >0 || $tour->image ) : ?>
                        <div class="listItemsImages">
                            <?php if( $tour->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $tour->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                            <?php
                            if( $tour->image )$i=2;
                            else $i=1;
                            foreach( $listImages as $LItem ) : ?>
                                <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                                <?php $i++;endforeach; ?>
                        </div>
                    <?php endif;?>
                </td>
                <td>
                    <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>.html" title="описание тура <?= $tour->name ?>"><?= $tour->name ?></a><br/>
                    <?= $tour->country_id->name." ".$tour->city_id->name ?>
                </td>
                <td class="textAlignJustify">
                    <?= SiteHelper::getSubTextOnWorld( $tour->description, 400 ) ?>
                    <div class="itemAction textAlignRight">
                        <a href="<?= SiteHelper::createUrl("/tours/description")."/".$tour->slug ?>.html">подробнее...</a><br/>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if( sizeof( $items ) == 0 ) : ?>
            <tr>
                <td colspan="6" class="textAlignCenter emptyList">Список пуст</td>
            </tr>
        <?php endif; ?>
    </table>
</div>