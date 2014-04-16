<h1>Рассылки</h1>
<div class="textAlignCenter">
    <a href="<?= SiteHelper::createUrl("/console/subscribe/users") ?>">Список новых пользователей |</a>
</div>
<br/>
<div id="consoleRightBlock">
    <b>Категории</b><br/>
    <?php foreach( $listCroup as $category ) : ?>
        <a <?= $activeCategory==$category->id ? 'class="selectCategory"' : "" ?> href="<?= SiteHelper::createUrl( "/console/subscribe", array( "group_id"=>$category->id) ) ?>"><?= $category->name ?></a>
    <?php endforeach; ?>
</div>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Отправлено</th>
        <th>Состояние</th>
        <th></th>
    </tr>
<?php foreach( $list as $item ) : ?>
    <tr>
        <td><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl( "/console/subscribe/edit", array( "id"=>$item->id ) ) ?>"><?= $item->name ?></a></td>
        <td><a href="<?= SiteHelper::createUrl( "/console/subscribe/stat", array( "id"=>$item->id ) ) ?>"><?= $item->count_send>0 ? $item->count_send : 0 ?></a></td>
        <td><?= $item->status_id->name ?></td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/console/subscribe/edit", array( "id"=>$item->id ) ) ?>">Редактировать</a>&nbsp;
            <a href="<?= SiteHelper::createUrl( "/console/subscribe", array( "id"=>$item->id ) ) ?>">Удалить</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<br/>
<div>
    <a href="<?= SiteHelper::createUrl( "/console/subscribe/edit", array( "group_id"=>$activeCategory ) ) ?>">[ добавить ]</a>
</div>