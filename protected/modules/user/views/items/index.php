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
        <td><div class="TImage"><img src="<?= ImageHelper::getImage( $item->image, 3 ) ?>" width="100" alt=""/></div></td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/items/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->name ?></a>
            <br/><font class="smallGrey"><?= $dateFinish>=time() ? $item->status_id->name : "не активно" ?></font>
        </td>
        <td><?= $item->type_id->name ?></td>
        <td><?= SiteHelper::getDateOnFormat( $dateFinish, "d.m.Y") ?></td>
        <td>
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <?php /* if( $dateFinish>=time() && $item->is_hot ==0 && $item->status_id->id == 1 ) : ?><a href="<?= SiteHelper::createUrl("/user/items/hot", array("id"=>$item->id)) ?>">Добавить в горячие</a><br/><?php endif;*/ ?>
                <?php if( $dateFinish<time() || $item->status_id->id == 3 ) : ?><a href="<?= SiteHelper::createUrl("/user/items/moderation", array("id"=>$item->id)) ?>">Опубликовать</a><br/><?php endif; ?>
                <?php if( $dateFinish>=time() && $item->status_id->id == 1 ) : ?><a href="<?= SiteHelper::createUrl("/user/items/nopublish", array("id"=>$item->id)) ?>">Снять с публикации</a><br/><?php endif; ?>
                <a href="<?= SiteHelper::createUrl("/user/items/description", array("id"=>$item->id)) ?>">Описание</a><br/>
                <a href="<?= SiteHelper::createUrl("/user/items", array("delete"=>$item->id)) ?>">Удалить</a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</div>