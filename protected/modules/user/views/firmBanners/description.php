<div id="innerPage">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            $firm->name=>SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "slug"=>$firm->slug ) ),
            Yii::t("user", "Описание баннера")
        ),
    ));
    ?>
    <h1><?= Yii::t("user", "Описание баннера" ) ?></h1>
    <div id="dopMenu" class="tourPage">
        <a href="<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "slug"=>$firm->slug ) ) ?>"><?= Yii::t("user", "вернуться к описанию фирмы" ) ?></a>
        <a href="<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "tab"=>"reclame" ) ) ?>"><?= Yii::t("user", "вернуться к списку рекламных баннеров" ) ?></a>

        <?php if( $item->id > 0 ) : ?>
            <br/><span><?= Yii::t("page", "статус"); ?>: <b class="publishStatus"><?= $item->active == 0 ? " ".Yii::t("user", "не опубликован")." " : " ".Yii::t("user", "опубликован")." " ?></b></span>
            <a href="#" class="publishLink linkButton" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl( "/user/firms/setPublish", array( "id"=>$item->id, "catalog"=>SiteHelper::getCamelCase( $item->tableName() ) ) ) ?>', '' );">
            <?php if( $item->active == 0 ) : ?><?= Yii::t("user", "Опубликовать на сайте ?") ?><?php endif; ?><?php if( $item->active == 1 ) : ?><?= Yii::t("user", "Снять с публикации ?") ?><?php endif; ?></a>
        <?php endif; ?>
    </div>
    <?php echo CHtml::errorSummary($item); ?><br>
    <?php if( !empty( $message ) ) : ?>
        <div class="messageSummary"><?= $message ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <table class="tableForm">
            <?=
                CCModelHelper::addForm( $item )
            ?>
            <tr>
                <td></td>
                <td>
                    <input type="button" onclick="window.location = '<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id ) ) ?>';" name="update" value="<?= Yii::t("user", "вернуться к описанию фирмы"); ?>" />&nbsp;
                    <input type="submit" name="update" value="<?= Yii::t("user", "Сохранить") ?>" />
                </td>
            </tr>
        </table>

    </form>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
    <?php if( $item->id>0 ) : ?>
        <br/>
        <?php if( sizeof( $listComments )>0 ) : ?>
            <h2><?= Yii::t("user", "Коментарии") ?></h2>
            <?= $comMessage ? '<div class="messageSummary">'.$comMessage.'</div>' : "" ?>
            <table id="tableListItems" class="tableComments">
                <tr>
                    <th><?= Yii::t("page", "Описание") ?></th>
                    <th><?= Yii::t("user", "Пользователь") ?></th>
                    <th><?= Yii::t("user", "Дата") ?></th>
                    <th><?= Yii::t("user", "Опубликовано") ?></th>
                    <th><?= Yii::t("page", "Действия") ?></th>
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
                        <td class="textAlignCenter"><?= ( $comm->is_valid == 0 ) ? Yii::t("page", "нет") : Yii::t("page", "да") ?></td>
                        <td>
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"delComment")) ?>"><?= Yii::t("user", "Удалить") ?></a>&nbsp;
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"validComment")) ?>"><?= Yii::t("user", "Отобразить на сайте") ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    <?php $this->widget( "formNoteWidget" ) ?>
</div>

