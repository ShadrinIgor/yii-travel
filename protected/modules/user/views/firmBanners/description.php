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

