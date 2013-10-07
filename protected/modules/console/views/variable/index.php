<h1>Переменные среды</h1>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
<?php foreach( $list as $item ) :?>
    <tr>
        <td class="fieldID"><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/variable/edit", array( "id"=>$item->id ))?>"><?= $item->message ?></a></td>
        <td><?= $item->category ?></td>
        <td class="fieldActions">
            <a href="<?= SiteHelper::createUrl("/console/variable/edit", array( "id"=>$item->id ))?>">Редактировать</a>
            <a href="<?= SiteHelper::createUrl("/console/variable/delete", array( "id"=>$item->id ))?>">Удалить</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<center>
    <a href="<?= SiteHelper::createUrl("/console/variable/edit" ) ?>">Добавить запись</a>
</center>