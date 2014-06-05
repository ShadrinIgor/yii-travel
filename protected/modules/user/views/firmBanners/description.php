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
                <th><?= Yii::t("user", "Разместить на главной"); ?></th>
                <td>
                    <?php if( !$checkedRequest ) : ?>
                        <?php if( $count<$maxCount ) : ?>
                            <input type="checkbox" name="banner_request" value="1" id="banner_request" /><b><label for="banner_request"><?= Yii::t("user", "Подать заявку"); ?></label></b><br/>
                            <span>
                                <?= Yii::t("user", "Для размещения бесплатного главного баннера сайта ( находящийся в верхней части сайта ) , необходимо заполнить все поля затем поставить галлочку и уже после этого нажать СОХРАНИТЬ."); ?><br/>
                                <?= Yii::t("user", "После получения заявки наш менеджер расмотрит Ваш баннер, и если он соответствует правилам сайта то сразу разместит сроком на 10 дней."); ?>
                            </span>
                            <hr/>
                        <?php endif; ?>
                        <?php if( $count == 0 ) : ?>
                            <div class="messageSummaryGreen"><?= Yii::t("user", "Еще не поданно не одной заявки Ваш банне может быть <b>ПЕРВЫМ</b> и пока <b>единственным</b>, торопитесь"); ?>....</div>
                        <?php elseif( $count<$maxCount ) : ?>
                            <?= Yii::t("user", "Полученно заявок"); ?>: <b><?= $count ?></b><br/>
                            <?= Yii::t("user", "Максимальное количество одновременных заявок"); ?>: <?= $maxCount ?>
                            <div class="messageSummaryGreen"><?= Yii::t("user", "Вы еще можете разместить Свой баннер на сайте, торопитесь мест осталось не много"); ?></div>
                        <?php else : ?>
                            <?= Yii::t("user", "Полученно заявок"); ?>: <b><?= $count ?></b><br/>
                            <?= Yii::t("user", "Максимальное количество одновременных заявок"); ?>: <?= $maxCount ?><br/>
                            <div class="errorSummary"><?= Yii::t("user", "К сожалению все заявки уже заняты, и сейчас Вы не можете разместить Свой баннер, через 10 дней будут приниматся новые завки, не <b>УПУСТИТЕ МОМЕНТ</b>"); ?> </div>
                        <?php endif; ?>
                    <?php else: ?>
                            <div class="messageSummaryGreen"><?= Yii::t("user", "Ваша заявка успешно принята и переданна на рссмотрение менеджеру, и если Ваш баннер соответствует правилам сайта то он сразу разместит его сроком на 10 дней. После размещение Вашего баннера менеджер пришлет Вам уведомление на "); ?><b><?= $firm->email ?></b>.<br/><?= Yii::t("user", "Если после подачи заявки пршло 2 или более дней,а баннер не размещен и нет уведомлнения, напшите в службу поддержки <b><a href='mailto: support@world-travel.uz'> support@world-travel.uz</a></b>, и мы обязательно проконтролируем."); ?></div>
                    <?php endif; ?>
                </td>
            </tr>
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

