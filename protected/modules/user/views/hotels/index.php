<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои отели" ),
    ));
?>
<h1>Мои отели</h1>
<?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-oteli" ) ?>
<?php if( $message ) :?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th class="TLFType">Страна</th>
        <th>Статус</th>
        <th class="TLFAction">Действия</th>
    </tr>
<?php foreach( $items as $item ):
        $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/user/hotels/description", array("id"=>$item->id) ) ) ?>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/hotels/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->name ?></a>
        </td>
        <td><?= $item->country_id->name.", ".$item->city_id->name ?></td>
        <td class="textAlignCenter publishStatus"><?= ( $item->active == 1 ) ? "опубликовано" : "не опубликовано" ?></td>
        <td class="textAlignCenter">
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <a href="<?= SiteHelper::createUrl("/user/hotels/description", array("id"=>$item->id)) ?>">Описание</a><br/>
                <div>
                    <?php if( $item->active == 1 ) : ?>
                        <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogHotels")) ?>', '' );">Снять с публикации</a><br/>
                    <?php else : ?>
                        <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$item->id, "catalog"=>"CatalogHotels")) ?>', '' );">Опубликовать</a><br/>
                    <?php endif; ?>
                </div>

                <div class="popup PMarginLeft">
                    <br/>
                    <b>Вы действительно хотите удалить запись?</b>
                    <br/><br/>
                    <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/hotels/delete", array("id"=>$item->id)) ?>">Удалить</a>
                </div>
                <a href="#" class="PDel">Удалить</a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
    <?php if( sizeof( $items ) == 0 ) : ?><div class="textAlignCenter">Yii::t("page", "Список пуст") );</div><?php endif; ?>
    <br/>
    <br/>
    <center>
        <a href="<?= SiteHelper::createUrl("/user/hotels/description") ?>">Добавить отель</a>
    </center>
</div>