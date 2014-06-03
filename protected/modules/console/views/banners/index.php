<h1>Banners</h1>
<h2>Категории банеров</h2>
<div class="oferflowHidden">
    <?php foreach( $bannersCategory as $item ) :?>
        <div class="CBannerCategoryItem">
            <a href="<?= SiteHelper::createUrl("/console/banners", array( "id"=>$item->id ))?>"><?= $item->name ?></a>
        </div>
    <?php endforeach; ?>
</div>
<br/>
<h2>Список баннеров</h2>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Count show</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
<?php foreach( $banners as $item ) :?>
    <tr>
        <td class="fieldID"><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/banners/edit", array( "id"=>$item->id ))?>"><?= $item->name ?></a></td>
        <td><?= $item->category->name ?></td>
        <td><?= $item->count_show ?></td>
        <td><?= $item->start_date ?></td>
        <td class="fieldActions">
            <a href="<?= SiteHelper::createUrl("/console/banners/edit", array( "id"=>$item->id ))?>">Редактировать</a>
            <a href="<?= SiteHelper::createUrl("/console/banners/delete", array( "id"=>$item->id ))?>"><?= Yii::t("user", "Удалить") ?></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<center>
    <a href="<?= SiteHelper::createUrl("/console/banners/edit" ) ?>">Добавить</a>
</center>