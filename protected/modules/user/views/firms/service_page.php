<h2>Дополнительные услуги</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th>Статус</th>
        <th>Просмотров</th>
        <th class="TLFAction">Действия</th>
    </tr>
    <?php

    foreach( $items as $service ): ?>
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
            <td class="textAlignCenter"><?= $service->col ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <?php if( $service->active == 1 ) : ?>
                        <a href="<?= SiteHelper::createUrl("/user/firmService/nopublish", array("id"=>$service->id, "fid"=>$item->id)) ?>">Снять с публикации</a><br/>
                    <?php else : ?>
                        <a href="<?= SiteHelper::createUrl("/user/firmService/publish", array("id"=>$service->id, "fid"=>$item->id)) ?>">Опубликовать</a><br/>
                    <?php endif; ?>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b>Вы действительно хотите удалить запись?</b>
                        <br/><br/>
                        <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                        <a href="<?= SiteHelper::createUrl("/user/firms/serviceDelete", array("id"=>$item->id, "tid"=>$service->id)) ?>">Удалить</a>
                    </div>
                    <a href="#" class="PDel">Удалить</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="6" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
    <tr>
        <td colspan="6" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/firmService/description", array("fid"=>$item->id)) ?>">[ добавить услугу ]</a><br/></td>
    </tr>
</table>