<h2><?= Yii::t("user", "Отзывы/Сообщения" ) ?></h2>
<?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-kabinet-otzyvy" ) ?>
<?php $this->widget("listNoteWidget") ?>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th sytle="width:400px" class="TLFName"><?= Yii::t("page", "Краткое описание") ?></th>
        <th><?= Yii::t("user", "Дата") ?></th>
        <th sytle="width:140px"><?= Yii::t("page", "статус"); ?></th>
        <th style="width: 130px;" class="TLFAction"><?= Yii::t("page", "Действия") ?></th>
    </tr>
    <?php
    foreach( $items as $service ): ?>
        <tr class="<?= $service->hot==1 ? 'isHot ' : "" ?><?= $service->is_new==1 ? 'isNewItem ' : "" ?><?= $service->active==1 ? 'publish  ' : "" ?>">
            <td><?= $service->id ?></td>
            <td>
                <a href="<?= SiteHelper::createUrl("/user/firmComments/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title="<?= Yii::t("page", "Описание акции/скидки") ?>"><?= $service->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $service->description, 550 ) ?>
                <br/><br/>
            </td>
            <td class="textAlignCenter"><?= SiteHelper::getDateOnFormat( $service->date, "d.m.Y H:i" ) ?></td>
            <td class="textAlignCenter"><?= ( $service->is_new == 1 ) ? "<div class=\"readNew\">новое<br/></div>" : "" ?><div class="publishStatus"><?= ( $service->active == 1 ) ? Yii::t("user", "опубликовано") : Yii::t("user", "не Опубликовано") ?></div></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmComments/description", array("id"=>$service->id, "fid"=>$item->id)) ?>"><?= Yii::t("page", "Описание") ?></a><br/>
                    <?php if( $service->is_new == 1 ) : ?>
                        <div class="readNew"><a href="#" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/commentRead", array("id"=>$service->id)) ?>', 'readItem' );"><?= Yii::t("user", "прочитанное") ?></a><br/></div>
                    <?php endif; ?>
                    <div>
                        <?php if( $service->active == 1 ) : ?>
                            <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$service->id, "catalog"=>"CatalogFirmsComments")) ?>', 'comment' );"><?= Yii::t("user", "Снять с публикации") ?></a><br/>
                        <?php else : ?>
                            <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$service->id, "catalog"=>"CatalogFirmsComments")) ?>', 'comment' );"><?= Yii::t("user", "Опубликовать") ?></a><br/>
                        <?php endif; ?>
                    </div>
                    <div class="popup PMarginLeft">
                        <br/>
                        <b><?= Yii::t("user", "Вы действительно хотите удалить запись?") ?></b>
                        <br/><br/>
                        <a href="#" class="PCancel"><?= Yii::t("user", "Отмена") ?> </a>&nbsp;|&nbsp;
                        <a href="#"  onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$service->id, "catalog"=>"CatalogFirmsComments")) ?>', '' );" class="deleteItem"><?= Yii::t("user", "Удалить") ?></a>
                    </div>
                    <a href="#" class="PDel"><?= Yii::t("user", "Удалить") ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList"><?= Yii::t("page", "Список пуст"); ?></td>
        </tr>
    <?php endif; ?>
</table>