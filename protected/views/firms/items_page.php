<h2>Акции/скидки компании</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php
    $listTours = CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
    foreach( $listTours as $firmItem ): ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $firmItem->id ?></td>
            <td>
                <?php
                if( !$firmItem->image )$countImages = 5;
                else $countImages = 4;

                $listImages = ImageHelper::getImages( $firmItem, $countImages );
                if( sizeof( $listImages ) >0 || $firmItem->image ) : ?>
                    <div class="listItemsImages">
                        <?php if( $firmItem->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $firmItem->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                        <?php
                        if( $firmItem->image )$i=2;
                        else $i=1;
                        foreach( $listImages as $LItem ) : ?>
                            <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                            <?php $i++;endforeach; ?>
                    </div>
                <?php endif;?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $firmItem->name ?></a>
            </td>
            <td class="textAlignJustify">
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 400 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $listTours ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>