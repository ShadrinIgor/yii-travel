<?php
    list( $arr ) = CatalogTours::sql( "SELECT sum(col) as sum_ FROM catalog_tours WHERE firm_id='".$item->id."'" );
    $countTour = $arr["sum_"] >0 ? $arr["sum_"] : 0;

    list( $arr ) = CatalogTours::sql( "SELECT sum(col) as sum_ FROM catalog_firms_banners WHERE firm_id='".$item->id."'" );
    $countBanners = $arr["sum_"] >0 ? $arr["sum_"] : 0;

    $listBanners = CatalogFirmsBanners::findByAttributes( array( "firm_id"=>$item->id ) );
?>
<h2>Статистика посещаемости</h2>
<?= SiteHelper::getAnimateText( "tekstovka-dlya-stranicy-kabinet-statistika" ) ?>
<table align="center">
    <tr>
        <th>Количесво просмотров страниц о компании: </th>
        <td><?= $item->col ?></td>
    </tr>
    <tr>
        <th>Общее количество просмотров туров компании:</th>
        <td><?=  $countTour ?></td>
    </tr>
    <tr>
        <th>Общее количество просмотров баннеров:</th>
        <td><?=  $countBanners ?></td>
    </tr>
</table>
<?php if( $listBanners>0 ) : ?>
    <h3 align="center">Статистика по баннерам:</h3>
    <table align="center">
        <tr>
            <th>Название баннера</th>
            <th>Количество просмотров</th>
        </tr>
        <?php foreach( $listBanners as $banner ) : ?>
            <tr>
                <th align="right"><?= $banner->name ?>:</th>
                <td align="right"><?= $banner->col ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
