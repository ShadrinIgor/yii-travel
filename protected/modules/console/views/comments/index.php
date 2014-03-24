<h1>Комментарии</h1>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Заголовок</th>
        <th>Дата</th>
        <th>Запись</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
<?php foreach( $comments as $item ) :?>
    <tr>
        <?php
            $catalogClass = SiteHelper::getCamelCase( $item->catalog );
            $catalogItemModel = $catalogClass::fetch( $item->item_id );

            $status = "";
            if( $item->new == 1) $status = "новое";
                else
            {
                if( $item->active == 1) $status = "опубликован";
                                              else  $status = "не опубликован";
            }

        ?>
        <td class="fieldID"><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/comments/edit", array( "id"=>$item->id ))?>"><?= $item->name ?></a></td>
        <td><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y H:i" ) ?></td>
        <td><?= $catalogItemModel->name ?></td>
        <td><?= $status ?></td>
        <td class="fieldActions">
            <a href="<?= SiteHelper::createUrl("/console/comments/edit", array( "id"=>$item->id ))?>">Редактировать</a>
            <a href="<?= SiteHelper::createUrl("/console/comments/delete", array( "id"=>$item->id ))?>">Удалить</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<center>
    <a href="<?= SiteHelper::createUrl("/console/comments/edit" ) ?>">Добавить</a>
</center>