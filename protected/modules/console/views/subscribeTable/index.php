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
<?php foreach( $list as $item ) :
    $worldCount = 0;
    $uzCount = 0;
    $itemCount = 0;

    // Определеяем количество статей
    if( $item->info_category_id->id >0 )
    {
        $itemCount = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions( "category_id =:cid" )->setParams( [":cid"=>$item->info_category_id->id] ) );
    }
        elseif( $item->country_id->id >0 )$itemCount = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id = :cid" )->setParams( [":cid"=>$item->country_id->id] ) );
            elseif( $item->category_id->id > 0 )
            {
                $itemCountArr = CatalogInfo::sql( "SELECT count(id) as count_ FROM catalog_info WHERE id in ( SELECT leftId FROM cat_relations WHERE leftClass='CatalogInfo' AND rightId='".$item->category_id->id."' AND rightClass='CatalogToursCategory' )" );
                if( sizeof( $itemCountArr ) >0 )
                {
                    $itemCount = $itemCountArr[0]["count_"];
                }
            }

    if( $item->country_id->id >0 )$countryWhere = "country_id = ";

    $sql = "SELECT count(id) as count_ FROM catalog_tours WHERE active=1";
    if( $item->category_id->id > 0 )$sql .= " AND category_id='".$item->category_id->id."'";

    $worldCountArr = CatalogTours::sql( $sql." AND country_id='1' ");
    if( sizeof( $worldCountArr ) >0 )$worldCount = $worldCountArr[0]["count_"];

    if( $item->country_id->id >1 )
    {
        $uzCountArr = CatalogTours::sql($sql . " AND country_id='" . $item->country_id->id . "'");
        if( sizeof( $uzCountArr ) >0 )$uzCount = $uzCountArr[0]["count_"];
    }
        else
    {
        $uzCountArr = CatalogTours::sql( $sql." AND country_id!=1 " );
        if( sizeof( $uzCountArr ) >0 )$uzCount = $uzCountArr[0]["count_"];
    }

?>
    <tr <?= $item->active == 0 ? 'style="color: #afafaf;text-decoration: line-through;"' : '' ?>>
        <td class="fieldID"><?= $item->id ?></td>
        <td><?= $item->name ?></td>
        <td><?= $item->date2 ?></td>
        <td><?= $item->country_id->name ?></td>
        <td><?= $item->category_id->name ?></td>
        <td>
            <a href="<?= SiteHelper::createUrl("/console/subscribeTable/edit", array( "id"=>$item->id ) ) ?>">[ edit ]</a>&nbsp;
            <a href="<?= SiteHelper::createUrl("/console/subscribeTable/", array( "del"=>$item->id ) ) ?>">[ del ]</a><br/>
            <?php if(  $item->country_id->id <= 1 ) : ?>
                <a href="<?= SiteHelper::createUrl("/console/subscribeTable/show", array("id"=>$item->id)) ?>" target="_blank" >WORLD - <?= $worldCount ?></a><br/>
            <?php endif; ?>
            <?php if( $item->country_id->id != 1 ) : ?>
                <a href="<?= SiteHelper::createUrl("/console/subscribeTable/show", array("id"=>$item->id, "location"=> "uzb")) ?>" target="_blank" >UZB - <?= $uzCount ?></a><br/>
            <?php endif; ?>
            Статей - <?= $itemCount ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>