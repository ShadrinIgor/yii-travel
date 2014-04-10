<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои объявления" ),
    ));
?>
<h1>Мои объявления</h1>
<?php if( $message ) :?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<table id="tableListItems">
    <tr>
        <th class="TLFId">№</th>
        <th class="TLFImage">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th class="TLFType">Тип объявления</th>
        <th>Окончание<br/>публикации</th>
        <th class="TLFAction">Действия</th>
    </tr>
<?php foreach( $items as $item ):
        $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/user/items/description", array("id"=>$item->id) ) ) ?>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/items/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->name ?></a>
            <br/><font class="smallGrey"><?= $dateFinish>=time() ? $item->status_id->name : "не активно" ?></font>
        </td>
        <td><?= $item->type_id->name ?></td>
        <td><?= SiteHelper::getDateOnFormat( $dateFinish, "d.m.Y") ?></td>
        <td>
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <div>
                    <?php if( $item->active == 1 ) : ?>
                        <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogHotels")) ?>', '' );">Снять с публикации</a><br/>
                    <?php else : ?>
                        <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogHotels")) ?>', '' );">Опубликовать</a><br/>
                    <?php endif; ?>
                </div>
                <a href="<?= SiteHelper::createUrl("/user/items/description", array("id"=>$item->id)) ?>">Описание</a><br/>
                <div class="popup PMarginLeft">
                    <br/>
                    <b>Вы действительно хотите удалить запись?</b>
                    <br/><br/>
                    <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/items/delete", array("id"=>$item->id)) ?>">Удалить</a>
                </div>
                <a href="#" class="PDel">Удалить</a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</div>