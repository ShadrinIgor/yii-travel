<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
<?php foreach( $list as $item ) : ?>
    <tr>
        <td class="fieldID"><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$item->id )).$controller->params ?>"><?= $item->name ?></a></td>
        <td class="fieldActions">
            <a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$item->id )).$controller->params ?>">Редактировать</a>
            <a href="<?= SiteHelper::createUrl("/console/catalog/delete", array( "id"=>$item->id )).$controller->params ?>">Удалить</a>
        </td>
    </tr>
<?php endforeach; ?>
    <tr>
        <td colspan="3" align="center">
            <?php $this->widget( "paginatorWidget", array( "count"=>$allCount, "offset"=>50, "page"=>$page, "url"=>array( "/console/catalog", array("catalog"=>Yii::app()->request->getParam("catalog", "")) ) ) ); ?>
        </td>
    </tr>
</table>
<center>
    <a href="<?= SiteHelper::createUrl("/console/catalog/edit" ).$controller->params  ?>">Добавить запись</a>
</center>