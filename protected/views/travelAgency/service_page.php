<h2> <?= Yii::t("page", "Дополнительные услуги"); ?></h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class=""> <?= Yii::t("page", "Фото"); ?></th>
        <th class="TLFAction"> <?= Yii::t("page", "Краткое описание"); ?></th>
    </tr>
    <?php

    foreach( $items as $service ): ?>
        <tr <?= $service->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $service->id ?></td>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $service, SiteHelper::createUrl("/service/description", array("id"=>$service->id, "fid"=>$item->id)), Yii::t("page", "услуга компании")." ". $service->name ) ?>
            </td>
            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/service/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title=" <?= Yii::t("page", "услуга компании"); ?> <?= $service->name ?>"><?= $service->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $service->description, 400 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl( "/service/description" )."/".$service->slug ?>.html" title="<?= $service->name ?> -  <?= Yii::t("page", "услуга компании"); ?> <?= $service->firm_id->name ?>"> <?= Yii::t("page", "Описание"); ?></a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList"> <?= Yii::t("page", "Список пуст"); ?></td>
        </tr>
    <?php endif; ?>
</table>