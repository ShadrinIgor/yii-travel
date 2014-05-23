<h1>Языковые пременные</h1>
<table id="tableListItems">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
<?php foreach( $list as $item ) : ?>
    <tr>
        <td><?= $item->id ?></td>
        <td><?= $item->name ?></td>
        <td><?= $item->category ?></td>
        <td class="fieldActions">
            <a href="<?= SiteHelper::createUrl("/console/lang/edit", array( "id"=>$item->id ))?>">Редактировать</a>
            <a href="<?= SiteHelper::createUrl("/console/lang/delete", array( "id"=>$item->id ))?>">Удалить</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<center>
    <a href="<?= SiteHelper::createUrl("/console/lang/edit" ) ?>">Добавить</a>
</center>