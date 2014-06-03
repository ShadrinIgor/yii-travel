<h1>Список новых пользователей</h1>
<div class="textAlignCenter">
    <a href="<?= SiteHelper::createUrl("/console/subscribe") ?>">Вернутся к рассылкам |</a>&nbsp;
    <a href="<?= SiteHelper::createUrl("/console/subscribe/userEdit") ?>">Добавить нового |</a>
</div>
<br/>
<div id="consoleRightBlock">
    <b>Категории</b><br/>
    <?php foreach( $listCroup as $category ) : ?>
        <a <?= $activeCategory==$category->id ? 'class="selectCategory"' : "" ?> href="<?= SiteHelper::createUrl( "/console/subscribe/users", array( "group_id"=>$category->id) ) ?>"><?= $category->name ?></a>
    <?php endforeach; ?>
</div>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th><?= Yii::t("user", "Название") ?></th>
        <th>Email</th>
        <th>Состояние</th>
        <th></th>
    </tr>
<?php foreach( $list as $item ) : ?>
    <tr>
        <td><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl( "/console/subscribe/userEdit", array( "id"=>$item->id ) ) ?>"><?= $item->name ?></a></td>
        <td><?= $item->email ?></td>
        <td><?= $item->del ==0 ? "активен" : "не активен" ?></td>
        <td>
            <a href="<?= SiteHelper::createUrl( "/console/subscribe/userEdit", array( "id"=>$item->id ) ) ?>">Редактировать</a>&nbsp;
            <a href="<?= SiteHelper::createUrl( "/console/subscribe/userDelete", array( "id"=>$item->id ) ) ?>"><?= Yii::t("user", "Удалить") ?></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<br/>
<div>
    <a href="<?= SiteHelper::createUrl( "/console/subscribe/userEdit", array( "group_id"=>$activeCategory ) ) ?>">[ добавить ]</a>
</div>