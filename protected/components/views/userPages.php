<div id="innerPage">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            $adressTitle=>SiteHelper::createUrl( "/user/".Yii::app()->controller->getId() ),
            Yii::t("page", "Описание")
        ),
    ));
    ?>
    <h1><?= $h1Titile ?></h1>
    <div id="dopMenu" class="tourPage">
        <?php if( !empty( $sitePage ) ) : ?>
            <?= $sitePage ?><br/>
        <?php endif; ?>
        <?php if( $item->id >0 ) : ?>
            <span><?= Yii::t("page", "статус"); ?>: <b class="publishStatus"><?= $item->active == 0 ? " ".Yii::t("page", "не опубликован")." " : " ".Yii::t("page", "опубликован")." " ?></b></span>
            <a href="#" class="publishLink linkButton" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl( "/user/firms/setPublish", array( "id"=>$item->id, "catalog"=>SiteHelper::getCamelCase( $item->tableName() ) ) ) ?>', '' );">
            <?php if( $item->active == 0 ) : ?><?= Yii::t("page", "Опубликовать на сайте"); ?> ?<?php endif; ?><?php if( $item->active == 1 ) : ?><?= Yii::t("page", "Снять с публикации"); ?> ?<?php endif; ?></a>
        <?php endif; ?>
    </div>
    <?php echo CHtml::errorSummary($item); ?><br>
    <?php if( !empty( $message ) ) : ?>
        <div class="messageSummary"><?= $message ?></div>
    <?php endif; ?>

    <div id="gallery">
        <h2><?= Yii::t("page", "Галерея"); ?></h2>
        <?= $gallMessage ? '<div class="messageSummary">'.$gallMessage.'</div>' : "" ?>
        <?php if( $item->id==0 ) : ?>
            <div class="messageSummary"><?= Yii::t("page", "После сохранения вы сможете добавить фотографии"); ?>.</div>
        <?php else : ?>
        <form action="" method="post">
            <div class="listGallery">
                <?php if( !empty( $error ) ) : ?><div class="errorSummary"><?= Yii::t("page", "Произошла ошибка закачки фотографий<br/>Повторите заново учитывая указанные ниже правила добавления фотографий"); ?></div>
                <?php endif; ?>
                <?php if( sizeof( $listGallery ) == 0 ) : ?>
                    <div class="textAlignCenter"><?= Yii::t("page", "Список пуст") ?></div>
                <?php else : ?>
                    <?php foreach( $listGallery as $gall ) : ?>
                        <div class="LGItem">
                            <div>
                                <a href="<?= $gall->image ?>" data-lightbox="roadtrip"><img src="<?= ImageHelper::getImage( $gall->image, 3 ) ?>" /></a>
                            </div>
                            <input type="text" name="ITitle[<?= $gall->id ?>]" value="<?= $gall->name ?>" placeholder="<?= Yii::t("page", "описание фото"); ?>" /><br/>
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "gall_id"=>$gall->id, "action"=>"delGallery")) ?>"><?= Yii::t("page", "Удалить"); ?></a>&nbsp;
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if( sizeof( $listGallery )>0 ) : ?>
                <div class="textAlignCenter">
                    <input type="submit" name="saveTitle" value="<?= Yii::t("page", "Сохранить описание"); ?>" />&nbsp;
                </div>
            <?php endif; ?>
        </form>
        <div class="textAlignCenter">
            <input type="button" class="openDisplayNone" value="<?= Yii::t("page", "Добавить фото"); ?>" />
        </div>
        <div class="<?php if( empty( $_POST["sendGallery"] ) || $addImage->formMessage ) :?>displayNone <?php endif; ?>addForm">
            <?php echo CHtml::errorSummary($addImage); ?><br>
            <?= CHtml::form("","post", array("enctype"=>"multipart/form-data")) ?>
            <table class="tableListItems">
                <tr>
                    <td colspan="2"><input type="file" name="CatGallery[images][]" multiple="true" /></td>
                </tr>
                <tr>
                    <td>
                        <b><?= Yii::t("page", "Правила добавление фотографий"); ?></b><br/>
                        <ul>
                            <li><?= Yii::t("page", "Количество файлов не должно превышать 8 штук"); ?></li>
                            <li><?= Yii::t("page", "Размер одной фотографии не должен превышать 5mb"); ?></li>
                            <li><?= Yii::t("page", "Для загрузки допускаются файлы следующих типов jpg|jpeg"); ?></li>
                        </ul>

                        <b><?= Yii::t("page", "Внимание!"); ?></b><br/>
                        <?= Yii::t("page", "Вы можете добавлять несколько фотографий одновременно"); ?>.<br/>
                        <i>( <?= Yii::t("page", "Для этого необходимо нажать кнопку [ ctrl ] и выбрать поочередно необходимые фотографии"); ?></i>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="textAlignCenter">
                        <?= CHtml::submitButton( Yii::t("page", "Закачать фото"), array("name"=>"sendGallery") ) ?>
                    </td>
                </tr>
            </table>
            <?= CHtml::endForm(); ?>
            </form>
            <?php endif;?>
        </div>
    </div>
    <br/>

    <form action="" method="post" enctype="multipart/form-data">
        <table class="tableForm">
            <?=
            CCModelHelper::addForm( $item )
            ?>
            <tr>
                <td></td>
                <td>
                    <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()) ?>';" name="update" value="<?= Yii::t("page", "Отмена"); ?>" />&nbsp;
                    <input type="submit" name="update" value="<?= Yii::t("page", "Сохранить"); ?>" />
                </td>
            </tr>
        </table>
        <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
    </form>

    <?php if( $item->id>0 ) : ?>
        <br/>
        <?php if( sizeof( $listComments )>0 ) : ?>
            <h2><?= Yii::t("page", "Коментарии"); ?></h2>
            <?= $comMessage ? '<div class="messageSummary">'.$comMessage.'</div>' : "" ?>
            <table id="tableListItems" class="tableComments">
                <tr>
                    <th><?= Yii::t("page", "Описание"); ?></th>
                    <th><?= Yii::t("page", "Пользователь"); ?></th>
                    <th><?= Yii::t("page", "Дата"); ?></th>
                    <th><?= Yii::t("page", "Опубликовано"); ?></th>
                    <th><?= Yii::t("page", "Действия"); ?></th>
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
                        <td class="textAlignCenter"><?= ( $comm->is_valid == 0 ) ? Yii::t("page", "нет") : Yii::t("page", Yii::t("page", "да")) ?></td>
                        <td>
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"delComment")) ?>"><?= Yii::t("page", "Удалить"); ?></a>&nbsp;
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"validComment")) ?>"><?= Yii::t("page", "Отобразить на сайте"); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>

</div>

