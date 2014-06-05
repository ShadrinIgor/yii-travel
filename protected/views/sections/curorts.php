<?php if( $this->beginCache( "sectionsCurorts-".$item->id."_".Yii::app()->getLanguage(), array('duration'=> SiteHelper::getConfig( "firmDescriptionTours" ) ) ) ) : ?>
    <div id="CIHeader" class="overflowHidden">
        <?php
        // Категории
        $listCategory = CatalogKurortsCategory::sql( "SELECT id, owner FROM `catalog_kurorts_category` WHERE owner>0 AND id IN( SELECT category_id FROM catalog_kurorts WHERE ".$kurortsSQL." AND del=0  AND active=1 )" );
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
            $ownerCategoryModel = CatalogKurortsCategory::fetch( $category );
            $array = array();
            foreach( $value as $cid )
            {
                if( $cid>0 )
                {
                    $obj = CatalogKurortsCategory::fetch($cid);
                    $array[] = $obj;
                }
            }
            $reCategory2[ $ownerCategoryModel->name ] = $array;
        }

        ?>

        <div class="CICategory">
            <div class="CICLabel"><?= Yii::t("page", "Категории"); ?></div>
            <div class="CICategoryScrool">
                <ul>
                    <?php foreach( $reCategory2 as $cItem=>$values ) : ?>
                        <li>
                            <b><?= $cItem ?></b>
                            <ul>
                                <?php foreach( $values as $cKey=>$cValue ) : ?>
                                    <li><a href="<?= SiteHelper::createUrl("/sections")."/".$item->slug ?>.html?ccategory=<?= $cValue->slug ?>&tab=curorts" title="<?= Yii::t("page", "категория зон отдыха"); ?> - <?= $cValue->name ?> "><?= $cValue->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php $this->endCache();endif; ?>

<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class=""><?= Yii::t("page", "Фото"); ?></th>
        <th class="TLFAction"><?= Yii::t("page", "Краткое описание"); ?></th>
    </tr>
    <?php

    foreach( $items as $firmItem ):
        ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/resorts/description" )."/".$firmItem->slug.".html") ?>
            </td>            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/resorts/description")."/".$firmItem->slug ?>.html" title="<?= Yii::t("page", "описание туристического предложения"); ?>"><?= $firmItem->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 300 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl("/resorts/category")."/".$firmItem->category_id->slug ?>.html"><?= $firmItem->category_id->name ?></a><br/>
                    <a href="<?= SiteHelper::createUrl("/resorts/description")."/".$firmItem->slug ?>.html"><?= Yii::t("page", "Описание"); ?></a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" align="center">
            <?php
            $this->widget( "paginatorWidget", array( "count"=>$curortsCount, "page"=>$page, "offset"=>$offset, "url"=>"&action=c".( !empty( $category ) ? "&ccategory=".$category : "" ) ) );

            ?>
            <br/>
        </td>
    </tr>
    <?php if( sizeof( $items ) == 0 ) : ?>

                            <?= Yii::t("page", Yii::t("page", "Список пуст") ); ?></td>
        </tr>
    <?php endif; ?>
</table>