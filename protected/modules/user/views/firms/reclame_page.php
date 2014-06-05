<h2><?= Yii::t("user", "Рекламные баннеры компании"); ?></h2>
<?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-kabinet-reklamnyi-banner" ) ?>
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

    foreach( $items as $banner ): ?>
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
                <a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array("id"=>$banner->id, "fid"=>$item->id)) ?>" title="<?= Yii::t("user", "описание акции/скидки"); ?>"><?= $banner->name ?></a>
            </td>
            <td class="textAlignCenter publishStatus"><?= ( $banner->active == 1 ) ? Yii::t("user", "опубликовано") : Yii::t("user", "не Опубликовано") ?></td>
            <td class="textAlignCenter"><?= $banner->col ?></td>
            <td class="textAlignCenter">
                <a href="#" class="aAction"></a>
                <div class="itemAction textAlignCenter">
                    <a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array("id"=>$banner->id, "fid"=>$item->id)) ?>"><?= Yii::t("page", "Описание") ?></a><br/>
                    <div>
                        <?php if( $banner->active == 1 ) : ?>
                            <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$banner->id, "catalog"=>"CatalogFirmsBanners")) ?>', '' );"><?= Yii::t("user", "Снять с публикации") ?></a><br/>
                        <?php else : ?>
                            <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$banner->id, "catalog"=>"CatalogFirmsBanners")) ?>', '' );"><?= Yii::t("user", "Опубликовать") ?></a><br/>
                        <?php endif; ?>
                    </div>

                    <div class="popup PMarginLeft">
                        <br/>
                        <b><?= Yii::t("user", "Вы действительно хотите удалить запись?") ?></b>
                        <br/><br/>
                        <a href="#" class="PCancel"><?= Yii::t("user", "Отмена") ?> </a>&nbsp;|&nbsp;
                        <a href="#"  onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$banner->id, "catalog"=>"CatalogFirmsBanners")) ?>', '' );" class="deleteItem"><?= Yii::t("user", "Удалить") ?></a>
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
        <td colspan="6" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array("fid"=>$item->id)) ?>">[ добавить банер ]</a><br/></td>
    </tr>
</table>