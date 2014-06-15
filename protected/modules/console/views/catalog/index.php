<?php if( sizeof( $listCategory ) >0 ) :
    $activeCategory = Yii::app()->request->getParam("category_id", 0);
    ?>
    <div id="consoleRightBlock">
        <?php foreach( $listCategory as $category ) : ?>
            <a <?= $activeCategory==$category->id ? 'class="selectCategory"' : "" ?> href="<?= SiteHelper::createUrl( "/console/catalog", array( "catalog"=>$catalogClass, "category_id"=>$category->id) ) ?>"><?= $category->name ?></a>
        <?php endforeach; ?>
        <a <?= $activeCategory==$category->id ? 'class="selectCategory"' : "" ?> href="<?= SiteHelper::createUrl( "/console/catalog", array( "catalog"=>$catalogClass, "category_id"=>0) ) ?>">Вне категорий</a>
    </div>
<?php endif; ?>
<div>
    <form action="<?= SiteHelper::createUrl( "/console/catalog", array( "catalog"=>$catalogClass ) ) ?>" method="post">
        Найти: <input type="text" name="find" value="<?= Yii::app()->request->getParam( "find", "") ?>" placeholder="ID или слово" />
        &nbsp;<input type="submit" name="submit_find" value="Найти" />
        <input type="button" onclick="window.location='<?= SiteHelper::createUrl( "/console/catalog", array( "catalog"=>$catalogClass ) ) ?>'" name="cansel" value="Сбросить" />
    </form>
</div>
<table id="tableListItems">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <?= property_exists( $catalogClass, "category_id" ) ? "<th>Category</th>" : "" ?>
        <?= property_exists( $catalogClass, "key_word" ) ? "<th>Key word</th>" : "" ?>
        <?= property_exists( $catalogClass, "slug" ) ? "<th>Slug</th>" : "" ?>
        <?= property_exists( $catalogClass, "active" ) ? "<th>Статус</th>" : "" ?>
        <?= property_exists( $catalogClass, "firm_id" ) ? "<th>Фирма</th>" : "" ?>
        <th>Actions</th>
    </tr>
<?php foreach( $list as $item ) : ?>
    <tr>
        <td class="fieldID"><?= $item->id ?></td>
        <td><a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$item->id )).$controller->params ?>"><?= $item->name ?></a></td>
        <?php if( property_exists( $catalogClass, "category_id" ) ) :?>
            <td><?= $item->category_id->name ?></td>
        <?php endif; ?>
        <?php if( property_exists( $catalogClass, "key_word" ) ) :?>
            <td><?= $item->key_word ?></td>
        <?php endif; ?>
        <?php if( property_exists( $catalogClass, "slug" ) ) :?>
            <td><?= $item->slug ?></td>
        <?php endif; ?>
        <?php if( property_exists( $catalogClass, "active" ) ) :?>
            <td><?= $item->active == 1 ? "опубликован" : "не опубликован" ?></td>
        <?php endif; ?>
        <?php if( property_exists( $catalogClass, "firm_id" ) ) :?>
            <td><?= $item->firm_id->id." ".$item->firm_id->name ?></td>
        <?php endif; ?>
        <td class="fieldActions">
            <a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$item->id )).$controller->params ?>">Редактировать</a>
            <a href="<?= SiteHelper::createUrl("/console/catalog/delete", array( "id"=>$item->id )).$controller->params ?>"><?= Yii::t("user", "Удалить") ?></a>
        </td>
    </tr>
<?php endforeach; ?>
    <tr>
        <td colspan="3" align="center">
            <?php $this->widget( "paginatorWidget", array( "count"=>$allCount, "offset"=>50, "page"=>$page, "url"=>array( "/console/catalog", $arrayParams ) ) ); ?>
        </td>
    </tr>
</table>
<center>
    <a href="<?= SiteHelper::createUrl("/console/catalog/edit" ).$controller->params  ?>">Добавить запись</a>
</center>