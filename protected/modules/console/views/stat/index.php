<h1>Лог</h1>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Каталог</th>
        <th>Действие</th>
        <th>ID записи</th>
        <th>Дата</th>
        <th>Пользователь</th>
    </tr>
<?php foreach( $list as $item ) :?>
    <tr>
        <td class="fieldID"><?= $item->id ?></td>
        <td><?= $item->catalog ?></td>
        <td><?= $item->action ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$item->item_id ) )."?catalog=".SiteHelper::getCamelCase( $item->catalog ) ?>" target="_blank"><?= $item->item_id ?></a></td>
        <td><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y H:i" ) ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$item->user_id ) )."?catalog=CatalogUsers" ?>" target="_blank"><?= $item->user_id." ".$item->user_id->name ?></a></td>
    </tr>
<?php endforeach; ?>
</table>