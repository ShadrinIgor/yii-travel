<?php if( $this->beginCache( "sectionsTours-".$item->id, array('duration'=> SiteHelper::getConfig( "firmDescriptionTours" ) ) ) ) : ?>
    <div id="CIHeader" class="overflowHidden">
        <?php
        // Категории
        $listCategory = CatalogToursCategory::sql( "SELECT id, owner FROM `catalog_tours_category` WHERE owner>0 AND id IN( SELECT category_id FROM catalog_tours WHERE ".$toursSQL." AND del=0  AND active=1 )" );
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
        $listCountry = CatalogCountry::sql( "SELECT id FROM `catalog_country` WHERE id IN( SELECT country_id FROM catalog_tours WHERE ".$toursSQL." AND del=0 AND active=1 )" );

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
                                    <li><a href="<?= SiteHelper::createUrl("/sections")."/".$item->slug ?>.html?category=<?= $cValue->slug ?>&tab=tours" title="категория туров - <?= $cValue->name ?> "><?= $cValue->name ?></a></li>
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
                        <li><a href="<?= SiteHelper::createUrl("/sections")."/".$item->slug ?>.html?country=<?= $values->slug ?>&tab=tours" title="туры <?= $values->name_2 ?>"><?= $values->name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php $this->endCache();endif; ?>

<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="">Фото</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php

    foreach( $tours as $firmItem ):
        ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/tours/description" )."/".$firmItem->slug.".html") ?>
            </td>
            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/tours/description")."/".$firmItem->slug ?>.html" title="описание туристического предложения"><?= $firmItem->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 300 ) ?>
                <div class="itemAction textAlignRight">
                    <?php if( $firmItem->country_id->id > 0 ) : ?><a href="<?= SiteHelper::createUrl("/tours/country")."/".$firmItem->country_id->slug ?>.html"><?= $firmItem->country_id->name ?></a><br/><?php endif; ?>
                    <a href="<?= SiteHelper::createUrl("/tours/category")."/".$firmItem->category_id->slug ?>.html"><?= $firmItem->category_id->name ?></a><br/>
                    <a href="<?= SiteHelper::createUrl("/tours/description")."/".$firmItem->slug ?>.html">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" align="center">
            <?php
            $this->widget( "paginatorWidget", array( "count"=>$tourCount, "page"=>$page, "offset"=>$offset, "url"=>"&action=t".( !empty( $country ) ? "&country=".$country : "" ).( !empty( $category ) ? "&category=".$category : "" ) ) );

            ?>
            <br/>
        </td>
    </tr>
    <?php if( sizeof( $tours ) == 0 ) : ?>
        <tr>
            <td colspan="3" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>