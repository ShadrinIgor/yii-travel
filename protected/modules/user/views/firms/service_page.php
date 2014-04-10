<h2>Дополнительные услуги</h2>
<?php $this->widget("listNoteWidget") ?>
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
                <?= ImageHelper::getAnimateImageBlock( $service, SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ) ?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $service->name ?></a>
            </td>
            <td class="textAlignCenter publishStatus"><?= ( $service->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
            <td class="textAlignCenter"><?= $service->col ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <div>
                        <?php if( $service->active == 1 ) : ?>
                            <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$service->id, "catalog"=>"CatalogFirmsService")) ?>', '' );">Снять с публикации</a><br/>
                        <?php else : ?>
                            <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$service->id, "catalog"=>"CatalogFirmsService")) ?>', '' );">Опубликовать</a><br/>
                        <?php endif; ?>
                    </div>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b>Вы действительно хотите удалить запись?</b>
                        <br/><br/>
                        <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                        <a href="#"  onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$service->id, "catalog"=>"CatalogFirmsService")) ?>', '' );" class="deleteItem">Удалить</a>
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