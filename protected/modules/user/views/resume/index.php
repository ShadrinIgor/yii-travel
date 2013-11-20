<div id="innerPage">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои вакансии" ),
    ));
    ?>
<h1>Мои резюме</h1>
    <?php if( $message ) :?>
        <div class="messageSummary"><?= $message ?></div>
    <?php endif; ?>
    <table id="tableListItems">
        <tr>
            <th class="TLFId">№</th>
            <th class="TLFName">Заголовок</th>
            <th class="TLFType">Категория</th>
            <th>Окончание<br/>публикации</th>
            <th>Статус</th>
            <th class="TLFAction">Действия</th>
        </tr>
        <?php foreach( $items as $item ):
            $dateFinish = $item->date + 60*60*24*30;
            ?>
            <tr <?= $item->is_hot==1 ? 'class="isHot"' : "" ?>>
                <td><?= $item->id ?></td>
                <td>
                    <a href="<?= SiteHelper::createUrl( "/user/resume/description", array("id"=>$item->id) ) ?>" title="описание"><?= $item->name ?></a>
                </td>
                <td><?= $item->category_id->name ?></td>
                <td><?= SiteHelper::getDateOnFormat( $dateFinish, "d.m.Y") ?></td>
                <td class="textAlignCenter"><?= ( $item->is_active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
                <td class="textAlignCenter">
                    <a href="#" class="aAction"></a>
                    <div class="itemAction textAlignCenter">
                        <a href="<?= SiteHelper::createUrl("/user/resume/description", array("id"=>$item->id)) ?>">Описание</a><br/>
                        <?php if( $item->is_active == 1 ) : ?>
                            <a href="<?= SiteHelper::createUrl("/user/resume/nopublish", array("id"=>$item->id)) ?>">Снять с публикации</a><br/>
                        <?php else : ?>
                            <a href="<?= SiteHelper::createUrl("/user/resume/publish", array("id"=>$item->id)) ?>">Опубликовать</a><br/>
                        <?php endif; ?>

                        <div class="popup PMarginLeft">
                            <br/>
                            <b>Вы действительно хотите удалить запись?</b>
                            <br/><br/>
                            <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                            <a href="<?= SiteHelper::createUrl("/user/resume/delete", array("id"=>$item->id)) ?>">Удалить</a>
                        </div>
                        <a href="#" class="PDel">Удалить</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if( sizeof( $items ) == 0 ) : ?><div class="textAlignCenter">Список пуст</div><?php endif; ?>
    <br/>
    <br/>
    <center>
        <a href="<?= SiteHelper::createUrl("/user/resume/description") ?>">Добавить резюме</a>
    </center>
</div>