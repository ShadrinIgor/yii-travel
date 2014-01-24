<h2>Отзывы/Сообщения</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th sytle="width:400px" class="TLFName">Краткое описание</th>
        <th>Дата</th>
        <th sytle="width:140px">Статус</th>
        <th style="width: 130px;" class="TLFAction">Действия</th>
    </tr>
    <?php
    foreach( $items as $service ): ?>
        <tr class="<?= $service->hot==1 ? 'isHot ' : "" ?><?= $service->is_new==1 ? 'isNewItem ' : "" ?><?= $service->active==1 ? 'publish  ' : "" ?>">
            <td><?= $service->id ?></td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $service->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $service->description, 550 ) ?>
                <br/><br/>
            </td>
            <td class="textAlignCenter"><?= SiteHelper::getDateOnFormat( $service->date, "d.m.Y H:i" ) ?></td>
            <td class="textAlignCenter"><?= ( $service->is_new == 1 ) ? "<div class=\"readNew\">новое<br/></div>" : "" ?><div class="publishStatus"><?= ( $service->active == 1 ) ? "опубликовано" : "не опубликованно" ?></div></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <?php if( $service->is_new == 1 ) : ?>
                        <div class="readNew"><a href="#" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/commentRead", array("id"=>$service->id)) ?>', 'readItem' );">прочитанное</a><br/></div>
                    <?php endif; ?>
                    <div>
                        <?php if( $service->active == 1 ) : ?>
                            <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$service->id, "catalog"=>"CatalogFirmsComments")) ?>', 'comment' );">Снять с публикации</a><br/>
                        <?php else : ?>
                            <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$service->id, "catalog"=>"CatalogFirmsComments")) ?>', 'comment' );">Опубликовать</a><br/>
                        <?php endif; ?>
                    </div>
                    <div class="popup PMarginLeft">
                        <br/>
                        <b>Вы действительно хотите удалить запись?</b>
                        <br/><br/>
                        <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                        <a href="#"  onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$service->id, "catalog"=>"CatalogFirmsComments")) ?>', '' );" class="deleteItem">Удалить</a>
                    </div>
                    <a href="#" class="PDel">Удалить</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>