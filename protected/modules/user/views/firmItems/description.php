<div id="innerPage">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            "мои фирмы" => SiteHelper::createUrl( "/user/firms" ),
            $firm->name => SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "slug"=>$firm->slug ) ),
            "список акций компании" => SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "tab"=>"items" ) ),
            $firm->id > 0 ? $firm->name : "Описание тура"
        ),
    ));
    ?>
    <h1>Описание акции/скидки</h1>
    <div id="dopMenu" class="tourPage">
        <a href="<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "slug"=>$firm->slug ) ) ?>">вернуться к описанию фирмы</a>
        <a href="<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id, "tab"=>"items" ) ) ?>">вернуться к списку акций</a>
        <?php if( $item->id >0 ) : ?>
            <br/><span>статус: <b class="publishStatus"><?= $item->active == 0 ? " не опубликован " : " опубликован " ?></b></span>
            <a href="#" class="publishLink linkButton" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl( "/user/firms/setPublish", array( "id"=>$item->id, "catalog"=>SiteHelper::getCamelCase( $item->tableName() ) ) ) ?>', '' );">
            <?php if( $item->active == 0 ) : ?>Опубликовать на сайте ?<?php endif; ?><?php if( $item->active == 1 ) : ?>Снять с публикации ?<?php endif; ?></a>
        <?php endif; ?>
    </div>
    <?php echo CHtml::errorSummary($item); ?><br>
    <?php if( !empty( $message ) ) : ?>
        <div class="messageSummary"><?= $message ?></div>
    <?php endif; ?>

    <div id="gallery">
        <h2>Галлерея</h2>
        <?= $gallMessage ? '<div class="messageSummary">'.$gallMessage.'</div>' : "" ?>
        <?php if( $item->id==0 ) : ?>
            <div class="messageSummary">После сохранения вы сможете добавить фотографии.</div>
        <?php else : ?>
        <form action="" method="post">
            <div class="listGallery">
                <?php if( !empty( $error ) ) : ?><div class="errorSummary">Произошла ошибка закачки фотографий<br/>Повторите заново учитывая указанные ниже правила добавления фотографий</div>
                <?php endif; ?>
                <?php if( sizeof( $listGallery ) == 0 ) : ?><div class="textAlignCenter">Yii::t("page", "Список пуст") );</div><?php endif; ?>
                <?php foreach( $listGallery as $gall ) : ?>
                    <div class="LGItem">
                        <div>
                            <a href="<?= $gall->image ?>" data-lightbox="roadtrip"><img src="<?= ImageHelper::getImage( $gall->image, 3 ) ?>" /></a>
                        </div>
                        <input type="text" name="ITitle[<?= $gall->id ?>]" value="<?= $gall->name ?>" placeholder="описание фото" /><br/>
                        <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "gall_id"=>$gall->id, "action"=>"delGallery")) ?>">Удалить</a>&nbsp;
                    </div>
                <?php endforeach; ?>

            </div>
            <?php if( sizeof( $listGallery )>0 ) : ?>
                <div class="textAlignCenter">
                    <input type="submit" name="saveTitle" value="Сохранить описание" />&nbsp;
                </div>
            <?php endif; ?>
        </form>
        <div class="textAlignCenter">
            <input type="button" class="openDisplayNone" value="Добавить фото" />
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
                        <b>Правила добавление фотографий</b><br/>
                        <ul>
                            <li>Количество файлов не должно превышать 8 штук</li>
                            <li>Размер одной фотографии не должен первышать 5mb</li>
                            <li>Для загрузки допускаются файлы следующих типов jpg|jpeg</li>
                        </ul>

                        <b>Внимание!</b><br/>
                        Вы можете добавлять несколько фотографий одновременно.<br/>
                        <i>( Для этого необходимо нажать кнопку [ ctrl ] и выбрать поочередно необходимые фотографии )</i>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="textAlignCenter">
                        <?= CHtml::submitButton( "Закачать фото", array("name"=>"sendGallery") ) ?>
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
                    <input type="button" onclick="window.location = '<?= SiteHelper::createUrl( "/user/firms/description/", array( "id"=>$firm->id ) ) ?>';" name="update" value="вернуться к описанию фирмы" />&nbsp;
                    <input type="submit" name="update" value="Сохранить" />
                </td>
            </tr>
        </table>
        <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
    </form>

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

