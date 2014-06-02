<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои вакансии" ),
    ));
?>
<h1>Мои вакансии</h1>
<?php if( $message ) :?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<table id="tableListItems">
    <tr>
        <th class="TLFId">№</th>
        <th class="TLFImage">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th class="TLFType">Категория</th>
        <th><?= Yii::t("page", "статус"); ?></th>
        <th class="TLFAction">Действия</th>
    </tr>
<?php foreach( $items as $item ):
        $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/user/work/description", array("id"=>$item->id) ) ) ?>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/work/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->name ?></a><br/>
            <i>дата:<?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?></i>
        </td>
        <td><?= $item->category_id->name ?></td>
        <td class="textAlignCenter publishStatus"><?= ( $item->active == 1 ) ? "опубликовано" : "не опубликовано" ?></td>
        <td>
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <div>
                    <?php if( $item->active == 1 ) : ?>
                        <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogWork")) ?>', '' );">Снять с публикации</a><br/>
                    <?php else : ?>
                        <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogWork")) ?>', '' );">Опубликовать</a><br/>
                    <?php endif; ?>
                </div>
                <a href="<?= SiteHelper::createUrl("/user/work/description", array("id"=>$item->id)) ?>">Описание</a><br/>
                <div class="popup PMarginLeft">
                    <br/>
                    <b>Вы действительно хотите удалить запись?</b>
                    <br/><br/>
                    <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/work/delete", array("id"=>$item->id)) ?>">Удалить</a>
                </div>
                <a href="#" class="PDel">Удалить</a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
    <div class="textAlignCenter"><br/><a href="<?= SiteHelper::createUrl( "/user/work/description" ) ?>">[ Добавить вакансию ]</a></div>
</div>