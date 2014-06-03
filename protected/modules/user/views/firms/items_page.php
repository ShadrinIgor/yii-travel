<h2><?= Yii::t("user", "Акции/скидки компании"); ?></h2>
<?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-kabinet-akcii" ) ?>
<?php $this->widget("listNoteWidget") ?>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class=""><?= Yii::t("user", "Фото") ?></th>
        <th class="TLFName"><?= Yii::t("user", "Заголовок") ?></th>
        <th><?= Yii::t("page", "статус"); ?></th>
        <th><?= Yii::t("page", "просмотров") ?></th>
        <th class="TLFAction"><?= Yii::t("page", "Действия") ?></th>
    </tr>
    <?php

    foreach( $items as $firmItem ): ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $firmItem->id ?></td>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ) ?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>" title="<?= Yii::t("user", "Описание акции/скидки") ?>"><?= $firmItem->name ?></a>
            </td>
            <td class="textAlignCenter publishStatus"><?= ( $firmItem->active == 1 ) ? Yii::t("user", "опубликовано") : Yii::t("user", "не опубликовано") ?></td>
            <td class="textAlignCenter"><?= $firmItem->col ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("id"=>$firmItem->id, "fid"=>$item->id)) ?>"><?= Yii::t("page", "Описание") ?></a><br/>
                    <div>
                        <?php if( $firmItem->active == 1 ) : ?>
                            <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$firmItem->id, "catalog"=>"CatalogFirmsItems")) ?>', '' );"><?= Yii::t("user", "Снять с публикации") ?></a><br/>
                        <?php else : ?>
                            <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$firmItem->id, "catalog"=>"CatalogFirmsItems")) ?>', '' );"><?= Yii::t("user", "Опубликовать") ?></a><br/>
                        <?php endif; ?>
                    </div>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b><?= Yii::t("user", "Вы действительно хотите удалить запись?") ?></b>
                        <br/><br/>
                        <a href="#" class="PCancel"><?= Yii::t("user", "Отмена") ?> </a>&nbsp;|&nbsp;
                        <a href="#" onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$firmItem->id, "catalog"=>"CatalogFirmsItems")) ?>', '' );" class="deleteItem"><?= Yii::t("user", "Удалить") ?></a>
                    </div>
                    <a href="#" class="PDel"><?= Yii::t("user", "Удалить") ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="6" class="textAlignCenter emptyList"><?= Yii::t("page", "Список пуст"); ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td colspan="6" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/firmItems/description", array("fid"=>$item->id)) ?>">[ добавить новую акцию/скиду ]</a><br/></td>
    </tr>
</table>