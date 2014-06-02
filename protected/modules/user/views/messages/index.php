<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои сообщения" ),
    ));
?>
<h1>Мои сообщения</h1>
<?php if( $message ) :?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<table id="tableListItems">
    <tr>
        <th class="TLFId">№</th>
        <th class="TLFName">Заголовок</th>
        <th class="TLFName">Дата</th>
        <th class="TLFName"><?= Yii::t("page", "статус"); ?></th>
        <th class="TLFAction">Действия</th>
    </tr>
<?php foreach( $items as $item ):
        $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_new==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/messages/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->subject ?></a>
        </td>
        <td><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y H:i" ) ?></td>
        <td><?= $item->is_new == 1 ? "новое" : "прочитанно" ?></td>
        <td>
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <a href="<?= SiteHelper::createUrl("/user/messages/description", array("id"=>$item->id)) ?>">Подробнее</a><br/>
                <div class="popup PMarginLeft">
                    <br/>
                    <b>Вы действительно хотите удалить запись?</b>
                    <br/><br/>
                    <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/messages/delete", array("id"=>$item->id)) ?>">Удалить</a>
                </div>
                <a href="#" class="PDel">Удалить</a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</div>