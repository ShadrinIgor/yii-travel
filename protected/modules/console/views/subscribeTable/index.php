<h1>Таблица рассылки</h1>

<br/>
<a href="<?= SiteHelper::createUrl("/console/subscribeTable/generation") ?>">Сгенерировать таблицу</a>&nbsp;|
<a href="<?= SiteHelper::createUrl("/console/subscribeTable/?action=recheck") ?>">Пересчитать</a>

<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Дата</th>
        <th>Страна</th>
        <th>Категория<br/>тура</th>
        <th>Действие</th>
    </tr>
<?php foreach( $list as $item ) :?>
    <tr>
        <td class="fieldID"><?= $item->id ?></td>
        <td><?= $item->name ?></td>
        <td><?= $item->date2 ?></td>
        <td><?= $item->country_id->name ?></td>
        <td><?= $item->category_id->name ?></td>
        <td>
            <a href="<?= SiteHelper::createUrl("/console/subscribeTable/edit", array( "id"=>$item->id ) ) ?>">[ edit ]</a>&nbsp;
            <a href="<?= SiteHelper::createUrl("/console/subscribeTable/delete", array( "id"=>$item->id ) ) ?>">[ del ]</a><br/>
            <?php if(  $item->country_id->id <= 1 ) : ?>
                <a href="<?= SiteHelper::createUrl("/console/subscribeTable/show", array("id"=>$item->id)) ?>" target="_blank" >[ WORLD ]</a><br/>
            <?php endif; ?>
            <?php if( $item->country_id->id != 1 ) : ?>
                <a href="<?= SiteHelper::createUrl("/console/subscribeTable/show", array("id"=>$item->id, "location"=> "uzb")) ?>" target="_blank" >[ UZB ]</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>