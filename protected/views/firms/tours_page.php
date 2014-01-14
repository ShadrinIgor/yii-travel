<div id="firmTours">
    <h2>Туры компании</h2>
    <table id="tableListItems" cellpadding="0" cellspacing="0">
        <tr>
            <th class="TLFId">№</th>
            <th class="">Фото</th>
            <th class="TLFName">Заголовок</th>
            <th class="TLFType">Страна</th>
            <th>Статус</th>
            <th class="TLFAction">Действия</th>
        </tr>
        <?php
        $listTours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
        foreach( $listTours as $tour ): ?>
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
                    <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id)) ?>" title="описание"><?= $tour->name ?></a>
                </td>
                <td><?= $tour->country_id->name.", ".$tour->city_id->name ?></td>
                <td class="textAlignCenter"><?= ( $tour->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
                <td class="textAlignCenter">
                    <a href="#" class="aAction"></a>
                    <div class="itemAction textAlignCenter">
                        <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if( sizeof( $listTours ) == 0 ) : ?>
            <tr>
                <td colspan="6" class="textAlignCenter emptyList">Список пуст</td>
            </tr>
        <?php endif; ?>
    </table>
</div>