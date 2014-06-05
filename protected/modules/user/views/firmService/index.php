<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( Yii::t("user", "мои фирмы") ),
    ));
?>
<h1><?= Yii::t("user", "Акции скидки" ) ?></h1>
<?php if( $message ) :?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class=""><?= Yii::t("user", "Фото") ?></th>
        <th class="TLFName"><?= Yii::t("user", "Заголовок") ?></th>
        <th class="TLFType"><?= Yii::t("page", "Страна"); ?></th>
        <th><?= Yii::t("page", "статус"); ?></th>
        <th class="TLFAction"><?= Yii::t("page", "Действия") ?></th>
    </tr>
<?php foreach( $items as $item ):
        // $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/user/tours/description", array("id"=>$item->id) ) ) ?>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/tours/description", array("id"=>$item->id) ) ?>" title="<?= Yii::t("page", "Описание") ?>"><?= $item->name ?></a>
        </td>
        <td><?= $item->country_id->name.", ".$item->city_id->name ?></td>
        <td class="textAlignCenter"><?= ( $item->is_active == 1 ) ? Yii::t("user", "опубликовано") : Yii::t("user", "не Опубликовано") ?></td>
        <td class="textAlignCenter">
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$item->id)) ?>"><?= Yii::t("page", "Описание") ?></a><br/>
                <?php if( $item->is_active == 1 ) : ?>
                    <a href="<?= SiteHelper::createUrl("/user/tours/nopublish", array("id"=>$item->id)) ?>"><?= Yii::t("user", "Снять с публикации") ?></a><br/>
                <?php else : ?>
                    <a href="<?= SiteHelper::createUrl("/user/tours/publish", array("id"=>$item->id)) ?>">Опубликовать</a><br/>
                <?php endif; ?>

                <div class="popup PMarginLeft">
                    <br/>
                    <b><?= Yii::t("user", "Вы действительно хотите удалить запись?") ?></b>
                    <br/><br/>
                    <a href="#" class="PCancel"><?= Yii::t("user", "Отмена") ?> </a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/tours/delete", array("id"=>$item->id)) ?>"><?= Yii::t("user", "Удалить") ?></a>
                </div>
                <a href="#" class="PDel"><?= Yii::t("user", "Удалить") ?></a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
    <?php if( sizeof( $items ) == 0 ) : ?><div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div><?php endif; ?>
    <br/>
    <br/>
    <center>
        <a href="<?= SiteHelper::createUrl("/user/tours/description") ?>">[ <?= Yii::t("user", "Добавить новый тур") ?> ]</a>
    </center>
</div>