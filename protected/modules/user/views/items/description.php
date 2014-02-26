<div id="innerPage">
<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
                    "Мои объявления"=>SiteHelper::createUrl( "/user/items" ),
                    "Описание"
                  ),
));
?>
<h1>Описание объявления</h1>
<?php echo CHtml::errorSummary($item); ?><br>
<?php if( !empty( $message ) ) : ?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
    <?php if( $item->status_id == 1 ) : ?><div class="messageSummary"><p>После внесения изменений в объявление, объявление будет передано на модерацию.</p></div><?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <?php if( $item->status_id != 1 && sizeof($listGallery)<6 ) : ?>
            <div class="messageSummary">
                <?php
                    $textMinimumImage = CatalogContent::fetchByKeyWord( "image_minimum" );
                    echo $textMinimumImage->description;
                ?>
            </div>
        <?php endif; ?>
        <br/>
    <table class="tableForm">
        <?=
            CatalogCCModelHelper::addForm( $item )
        ?>
        <tr>
            <td></td>
            <td>
                <?php if( !empty( $item->param) ) : ?><input type="hidden" name="param_id" value="<?= $item->param->id ?>" /><?php endif; ?>
                <input type="submit" name="update_tree" value="Сохранить" /></td>
        </tr>
    </table>
</form>
<br/>

<div id="gallery">
    <h2>Галлерея</h2>
    <?= $gallMessage ? '<div class="messageSummary">'.$gallMessage.'</div>' : "" ?>
        <div class="listGallery">
            <?php foreach( $listGallery as $gall ) : ?>
                <div class="LGItem">
                    <div>
                        <a href="<?= $gall->image ?>" target="_blank"><img src="<?= ImageHelper::getImage( $gall->image, 3 ) ?>" /></a>
                    </div>
                    <?= $gall->name ?><br/>
                    <a href="<?= SiteHelper::createUrl("/user/items/description", array("id"=>$item->id, "gall_id"=>$gall->id, "action"=>"delGallery")) ?>">Удалить</a>&nbsp;
                </div>
            <?php endforeach; ?>
        </div>
    <div class="textAlignCenter"><input type="button" class="openDisplayNone" value="Добавить фото" /></div>
    <div class="<?php if( empty( $_POST["sendGallery"] ) || $addImage->formMessage ) :?>displayNone <?php endif; ?>addForm">
        <?php echo CHtml::errorSummary($addImage); ?><br>
        <?= CHtml::form("","post", array("enctype"=>"multipart/form-data")) ?>
            <table class="tableListItems">
                <?= CCModelHelper::addForm( $addImage ); ?>
                <tr>
                    <td colspan="2" class="textAlignCenter">
                        <?= CHtml::submitButton( "Добавить", array("name"=>"sendGallery") ) ?>
                    </td>
                </tr>
            </table>
        <?= CHtml::endForm(); ?>
        </form>
    </div>
</div>
<br/>
<?php if( sizeof( $listComments )>0 ) : ?>
    <h2>Коментарии</h2>
        <?= $comMessage ? '<div class="messageSummary">'.$comMessage.'</div>' : "" ?>
        <table id="tableListItems" class="tableComments">
            <tr>
                <th>Описание</th>
                <th>Пользователь</th>
                <th>Дата</th>
                <th>Опубликованно</th>
                <th>Действия</th>
            </tr>
        <?php foreach( $listComments as $comm ) : ?>
            <tr>
                <td class="IHeader">
                    <b><?= $comm->subject ?></b><br/>
                    <?= $comm->description ?>
                </td>
                <td>
                    <?php if( $comm->user_id ) : ?>
                        <?= $comm->user_id->name ?><br/>
                        <?= $comm->user_id->email ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?= SiteHelper::getDateOnFormat( $comm->date, "d.m.Y" ) ?>
                </td>
                <td class="textAlignCenter"><?= ( $comm->is_valid == 0 ) ? "нет" : "да" ?></td>
                <td>
                    <a href="<?= SiteHelper::createUrl("/user/items/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"delComment")) ?>">Удалить</a>&nbsp;
                    <a href="<?= SiteHelper::createUrl("/user/items/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"validComment")) ?>">Отобразить на сайте</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php $this->widget( "formNoteWidget" ) ?>