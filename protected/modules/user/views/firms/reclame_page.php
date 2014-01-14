<h2>Акции/скидки компании</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th>Статус</th>
        <th class="TLFAction">Действия</th>
    </tr>
    <?php
    $listTours = CatalogFirmsBanners::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
    foreach( $listTours as $banner ): ?>
        <tr <?= $banner->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $banner->id ?></td>
            <td>
                <?php
                if( !$banner->image )$countImages = 5;
                                else $countImages = 4;

                $listImages = ImageHelper::getImages( $banner, $countImages );
                if( sizeof( $listImages ) >0 || $banner->image ) : ?>
                    <div class="listItemsImages">
                        <?php if( $banner->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $banner->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                        <?php
                        if( $banner->image )$i=2;
                        else $i=1;
                        foreach( $listImages as $LItem ) : ?>
                            <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                            <?php $i++;endforeach; ?>
                    </div>
                <?php endif;?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array("id"=>$banner->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $banner->name ?></a>
            </td>
            <td class="textAlignCenter"><?= ( $banner->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array("id"=>$banner->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <?php if( $banner->active == 1 ) : ?>
                        <a href="<?= SiteHelper::createUrl("/user/firmBanners/nopublish", array("id"=>$banner->id, "fid"=>$item->id)) ?>">Снять с публикации</a><br/>
                    <?php else : ?>
                        <a href="<?= SiteHelper::createUrl("/user/firmBanners/publish", array("id"=>$banner->id, "fid"=>$item->id)) ?>">Опубликовать</a><br/>
                    <?php endif; ?>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b>Вы действительно хотите удалить запись?</b>
                        <br/><br/>
                        <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                        <a href="<?= SiteHelper::createUrl("/user/firms/bannerDelete", array("id"=>$item->id, "tid"=>$banner->id)) ?>">Удалить</a>
                    </div>
                    <a href="#" class="PDel">Удалить</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $listTours ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
    <tr>
        <td colspan="5" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array("fid"=>$item->id)) ?>">[ добавить банер ]</a><br/></td>
    </tr>
</table>