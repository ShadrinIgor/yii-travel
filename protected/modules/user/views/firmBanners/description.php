<div id="innerPage">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            $firm->name=>SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "slug"=>$firm->slug ) ),
            "Описание тура"
        ),
    ));
    ?>
    <h1>Описание баннера</h1>
    <div id="dopMenu" class="tourPage">
        <a href="<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "slug"=>$firm->slug ) ) ?>">вернуться к описанию фирмы</a>
        <a href="<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "tab"=>"reclame" ) ) ?>">вернуться к списку рекламных баннеров</a>

        <?php if( $item->id > 0 ) : ?>
            <br/><span>статус: <b class="publishStatus"><?= $item->active == 0 ? " не опубликован " : " опубликован " ?></b></span>
            <a href="#" class="publishLink linkButton" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl( "/user/firms/setPublish", array( "id"=>$item->id, "catalog"=>SiteHelper::getCamelCase( $item->tableName() ) ) ) ?>', '' );">
            <?php if( $item->active == 0 ) : ?>Опубликовать на сайте ?<?php endif; ?><?php if( $item->active == 1 ) : ?>Снять с публикации ?<?php endif; ?></a>
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
                <th>Расместить на главной</th>
                <td>
                    <?php if( !$checkedRequest ) : ?>
                        <?php if( $count<$maxCount ) : ?>
                            <input type="checkbox" name="banner_request" value="1" id="banner_request" /><b><label for="banner_request">Подать заявку</label></b><br/>
                            <span>
                                Для размещения бесплатного главного баннера сайта ( находящийся в верхней части сайта ) , необходимо заполнить все поля затем поставить галлочку и уже после этого нажать СОХРАНИТЬ.<br/>
                                После получения заявки наш менеджер расмотрит Ваш баннер, и если он соответствует правилам сайта то сразу разместит сроком на 10 дней.
                            </span>
                            <hr/>
                        <?php endif; ?>
                        <?php if( $count == 0 ) : ?>
                            <div class="messageSummaryGreen">Еще не поданно не одной заявки Ваш банне может быть <b>ПЕРВЫМ</b> и пока <b>единственным</b>, торопитесь....</div>
                        <?php elseif( $count<$maxCount ) : ?>
                            Полученно заявок: <b><?= $count ?></b><br/>
                            Максимальное количество одновременных заявок: <?= $maxCount ?><br/>
                            <div class="messageSummaryGreen">Вы еще можете разместить Свой баннер на сайте, торопитесь мест осталось не много</div>
                        <?php else : ?>
                            Полученно заявок: <b><?= $count ?></b><br/>
                            Максимальное количество одновременных заявок: <?= $maxCount ?><br/>
                            <div class="errorSummary">К сожалению все завяки уже заняты, и сейчас Вы не можете разместить Свой баннер, через 10 дней будут приниматся новые завки, не <b>УПУСТИТЕ МОМЕНТ</b> </div>
                        <?php endif; ?>
                    <?php else: ?>
                            <div class="messageSummaryGreen">Ваша заявка успешно принята и переданна на рссмотрение менеджеру, и если Ваш баннер соответствует правилам сайта то он сразу разместит его сроком на 10 дней. После размещение Вашего баннера менеджер пришлет Вам уведомление на <b><?= $firm->email ?></b>.<br/>Если после подачи заявки пршло 2 или более дней,а баннер не размещен и нет уведомлнения, напшите в службу поддержки <b><a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a></b>, и мы обязательно проконтролируем.</div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="button" onclick="window.location = '<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id ) ) ?>';" name="update" value="вернуться к описанию фирмы" />&nbsp;
                    <input type="submit" name="update" value="Сохранить" />
                </td>
            </tr>
        </table>

    </form>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
    <?php if( $item->id>0 ) : ?>
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
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"delComment")) ?>">Удалить</a>&nbsp;
                            <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "comm_id"=>$comm->id, "action"=>"validComment")) ?>">Отобразить на сайте</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    <?php $this->widget( "formNoteWidget" ) ?>
</div>

