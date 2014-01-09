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
    $listTours = CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
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
            <td class="textAlignCenter"><?= ( $firmItem->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <?php if( $firmItem->active == 1 ) : ?>
                        <a href="<?= SiteHelper::createUrl("/user/firmItems/nopublish", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>">Снять с публикации</a><br/>
                    <?php else : ?>
                        <a href="<?= SiteHelper::createUrl("/user/firmItems/publish", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>">Опубликовать</a><br/>
                    <?php endif; ?>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b>Вы действительно хотите удалить запись?</b>
                        <br/><br/>
                        <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                        <a href="<?= SiteHelper::createUrl("/user/firms/itemDelete", array("id"=>$item->id, "tid"=>$firmItem->id)) ?>">Удалить</a>
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
        <td colspan="5" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("fid"=>$item->id)) ?>">[ добавить новую акцию/скиду тур ]</a><br/></td>
    </tr>
</table>