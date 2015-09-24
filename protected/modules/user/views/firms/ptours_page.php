<div id="firmTours">
    <h2><?= Yii::t("user", "Туры компании"); ?></h2>
    <?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-kabinet-tury-kompanii" ) ?>
    <?php $this->widget("listNoteWidget") ?>
    <table id="tableListItems" cellpadding="0" cellspacing="0">
        <tr>
            <th class="TLFId">№</th>
            <th class=""><?= Yii::t("user", "Фото") ?></th>
            <th class="TLFName"><?= Yii::t("user", "Заголовок") ?></th>
            <th class="TLFType"><?= Yii::t("page", "Страна"); ?></th>
            <th><?= Yii::t("page", "статус"); ?></th>
            <th><?= Yii::t("page", "просмотров") ?></th>
            <th class="TLFAction"><?= Yii::t("page", "Действия") ?></th>
        </tr>
        <?php

        foreach( $items as $tour ): ?>
            <tr <?= $tour->hot==1 ? 'class="isHot"' : "" ?>>
                <td><?= $tour->id ?></td>
                <td>
                    <?= ImageHelper::getAnimateImageBlock( $tour, SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id) ) ) ?>
                </td>
                <td>
                    <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id)) ?>" title="описание"><?= $tour->name ?></a>
                </td>
                <td>

                <?php if( !empty( $tour->country_id ) || !empty( $tour->city_id ) ) : ?>
                    <?= !empty( $tour->country_id ) ? $tour->country_id->name : "" ?> <?= !empty( $tour->city_id ) ? $tour->city_id->name : "" ?></td>
                <?php endif; ?>
                <td class="textAlignCenter publishStatus"><?= ( $tour->active == 1 ) ? Yii::t("user", "опубликовано") : Yii::t("user", "не опубликовано") ?></td>
                <td class="textAlignCenter"><?= $tour->col ?></td>
                <td class="textAlignCenter">
                    <a href="#" class="aAction"></a>
                    <div class="itemAction textAlignCenter">
                        <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id)) ?>"><?= Yii::t("page", "Описание") ?></a><br/>
                        <div>
                            <?php if( $tour->active == 1 ) : ?>
                                <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$tour->id, "catalog"=>"CatalogTours")) ?>', '' );"><?= Yii::t("user", "Снять с публикации") ?></a><br/>
                            <?php else : ?>
                                <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$tour->id, "catalog"=>"CatalogTours")) ?>', '' );"><?= Yii::t("user", "Опубликовать") ?></a><br/>
                            <?php endif; ?>
                        </div>
                        <div class="popup PMarginLeft">
                            <b><?= Yii::t("user", "Вы действительно хотите удалить запись?") ?></b>
                            <br/><br/>
                            <a href="#" class="PCancel"><?= Yii::t("user", "Отмена") ?> </a>&nbsp;|&nbsp;
                            <a href="#" onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$tour->id, "catalog"=>"CatalogTours")) ?>', '' );" class="deleteItem"><?= Yii::t("user", "Удалить") ?></a>
                        </div>
                        <a href="#" class="PDel"><?= Yii::t("user", "Удалить") ?></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if( sizeof( $items ) == 0 ) : ?>
            <tr>
                <td colspan="7" class="textAlignCenter emptyList"><?= Yii::t("page", "Список пуст"); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td colspan="7" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/tours/description", array("fid"=>$item->id)) ?>">[ <?= Yii::t("user", "добавить новый тур"); ?> ]</a><br/></td>
        </tr>
    </table>
</div>