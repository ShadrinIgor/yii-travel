<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои фирмы" ),
    ));
?>
<h1>Туры фирмы</h1>
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
        // $dateFinish = $item->date + 60*60*24*30;
    ?>
    <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
        <td><?= $item->id ?></td>
        <td>
            <?php
                if( !$item->image )$countImages = 5;
                                      else $countImages = 4;

                $listImages = ImageHelper::getImages( $item, $countImages );
                if( sizeof( $listImages ) >0 || $item->image ) : ?>
                    <div class="listItemsImages">
                       <?php if( $item->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $item->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                       <?php
                            if( $item->image )$i=2;
                                         else $i=1;
                            foreach( $listImages as $LItem ) : ?>
                           <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                       <?php $i++;endforeach; ?>
                    </div>
                <?php endif;?>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/user/tours/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->name ?></a>
        </td>
        <td><?= $item->country_id->name.", ".$item->city_id->name ?></td>
        <td class="textAlignCenter"><?= ( $item->is_active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
        <td class="textAlignCenter">
            <a href="#" class="aAction"></a>
            <div class="itemAction textAlignCenter">
                <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$item->id)) ?>">Описание</a><br/>
                <?php if( $item->is_active == 1 ) : ?>
                    <a href="<?= SiteHelper::createUrl("/user/tours/nopublish", array("id"=>$item->id)) ?>">Снять с публикации</a><br/>
                <?php else : ?>
                    <a href="<?= SiteHelper::createUrl("/user/tours/publish", array("id"=>$item->id)) ?>">Опубликовать</a><br/>
                <?php endif; ?>

                <div class="popup PMarginLeft">
                    <br/>
                    <b>Вы действительно хотите удалить запись?</b>
                    <br/><br/>
                    <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/tours/delete", array("id"=>$item->id)) ?>">Удалить</a>
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
        <a href="<?= SiteHelper::createUrl("/user/tours/description") ?>">[ Добавить новый тур ]</a>
    </center>
</div>