<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( Yii::t("user", "Мои резюме") ),
    ));
?>
<h1><?= Yii::t("user", "Мои резюме") ?></h1>
<?php if( $message ) :?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<table id="tableListItems">
    <tr>
        <th class="TLFId">№</th>
        <th class="TLFImage"><?= Yii::t("user", "Фото") ?></th>
        <th class="TLFName"><?= Yii::t("user", "Заголовок") ?></th>
        <th class="TLFType"><?= Yii::t("user", "Категория") ?></th>
        <th><?= Yii::t("page", "статус"); ?></th>
        <th class="TLFAction"><?= Yii::t("page", "Действия") ?></th>
    </tr>
<?php foreach( $items as $item ):
        $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/user/resume/description", array("id"=>$item->id) ) ) ?>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/resume/description", array("id"=>$item->id) ) ?>" title="<?= Yii::t("user", "описание") ?>"><?= $item->name ?></a><br/>
            <i><?= Yii::t("user", "Дата") ?> :<?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?></i>
        </td>
        <td><?= $item->category_id->name ?></td>
        <td class="textAlignCenter publishStatus"><?= ( $item->active == 1 ) ? Yii::t("user", "опубликовано") : Yii::t("user", "не опубликовано") ?></td>
        <td>
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <div>
                    <?php if( $item->active == 1 ) : ?>
                        <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogWork")) ?>', '' );"><?= Yii::t("user", "Снять с публикации") ?></a><br/>
                    <?php else : ?>
                        <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogWork")) ?>', '' );"><?= Yii::t("user", "Опубликовать") ?></a><br/>
                    <?php endif; ?>
                </div>
                <a href="<?= SiteHelper::createUrl("/user/resume/description", array("id"=>$item->id)) ?>"><?= Yii::t("page", "Описание") ?></a><br/>
                <div class="popup PMarginLeft">
                    <br/>
                    <b><?= Yii::t("user", "Вы действительно хотите удалить запись?") ?></b>
                    <br/><br/>
                    <a href="#" class="PCancel"><?= Yii::t("user", "Отмена") ?> </a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/resume/delete", array("id"=>$item->id)) ?>"><?= Yii::t("user", "Удалить") ?></a>
                </div>
                <a href="#" class="PDel"><?= Yii::t("user", "Удалить") ?></a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
    <div class="textAlignCenter"><br/><a href="<?= SiteHelper::createUrl( "/user/resume/description" ) ?>">[ Добавить вакансию ]</a></div>
</div>