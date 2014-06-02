<h2>Акции/скидки компании</h2>
<?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-kabinet-akcii" ) ?>
<?php $this->widget("listNoteWidget") ?>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th><?= Yii::t("page", "статус"); ?></th>
        <th><?= Yii::t("page", "просмотров") ?></th>
        <th class="TLFAction">Действия</th>
    </tr>
    <?php

    foreach( $items as $firmItem ): ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $firmItem->id ?></td>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ) ?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $firmItem->name ?></a>
            </td>
            <td class="textAlignCenter publishStatus"><?= ( $firmItem->active == 1 ) ? "опубликовано" : "не опубликовано" ?></td>
            <td class="textAlignCenter"><?= $firmItem->col ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                    <div>
                        <?php if( $firmItem->active == 1 ) : ?>
                            <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$firmItem->id, "catalog"=>"CatalogFirmsItems")) ?>', '' );">Снять с публикации</a><br/>
                        <?php else : ?>
                            <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$firmItem->id, "catalog"=>"CatalogFirmsItems")) ?>', '' );">Опубликовать</a><br/>
                        <?php endif; ?>
                    </div>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b>Вы действительно хотите удалить запись?</b>
                        <br/><br/>
                        <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                        <a href="#" onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$firmItem->id, "catalog"=>"CatalogFirmsItems")) ?>', '' );" class="deleteItem">Удалить</a>
                    </div>
                    <a href="#" class="PDel">Удалить</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="6" class="textAlignCenter emptyList">Yii::t("page", "Список пуст") );</td>
        </tr>
    <?php endif; ?>
    <tr>
        <td colspan="6" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("fid"=>$item->id)) ?>">[ добавить новую акцию/скиду ]</a><br/></td>
    </tr>
</table>