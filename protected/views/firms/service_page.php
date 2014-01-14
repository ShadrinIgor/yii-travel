<h2>Дополнительные услуги</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th>Статус</th>
        <th class="TLFAction">Действия</th>
    </tr>
    <?php
    $listTours = CatalogFirmsService::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
    foreach( $listTours as $service ): ?>
        <tr <?= $service->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $service->id ?></td>
            <td>
                <?php
                if( !$service->image )$countImages = 5;
                else $countImages = 4;

                $listImages = ImageHelper::getImages( $service, $countImages );
                if( sizeof( $listImages ) >0 || $service->image ) : ?>
                    <div class="listItemsImages">
                        <?php if( $service->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $service->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                        <?php
                        if( $service->image )$i=2;
                        else $i=1;
                        foreach( $listImages as $LItem ) : ?>
                            <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                            <?php $i++;endforeach; ?>
                    </div>
                <?php endif;?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $service->name ?></a>
            </td>
            <td class="textAlignCenter"><?= ( $service->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>">Описание</a><br/>
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