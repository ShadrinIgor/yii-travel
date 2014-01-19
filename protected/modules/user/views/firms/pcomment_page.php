<h2>Отзывы/Сообщения</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th sytle="width:400px" class="TLFName">Краткое описание</th>
        <th>Дата</th>
        <th sytle="width:140px">Статус</th>
        <th class="TLFAction">Действия</th>
    </tr>
    <?php
    $listTours = CatalogFirmsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
    foreach( $listTours as $service ): ?>
        <tr <?= $service->hot==1 ? 'class="isHot"' : "" ?><?= $service->is_new==1 ? 'class="isNewItem"' : "" ?>>
            <td><?= $service->id ?></td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $service->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $service->description, 450 ) ?>
            </td>
            <td class="textAlignCenter"><?= SiteHelper::getDateOnFormat( $service->date, "d.m.Y H:i" ) ?></td>
            <td class="textAlignCenter"><?= ( $service->is_new == 1 ) ? "новое<br/>" : "" ?><?= ( $service->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$service->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <?php if( $service->is_new == 1 ) : ?>
                        <a href="#" onclick="ajaxAction( '<?= Yii::app()->params["baseUrl"].SiteHelper::createUrl("/user/firms/commentRead", array("id"=>$service->id)) ?>' );">прочитанное</a><br/>
                    <?php endif; ?>
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
    <?php if( sizeof( $listTours ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>