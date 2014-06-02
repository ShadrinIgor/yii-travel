<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Мои заказы" ),
    ));
?>
<h1>Мои заказы</h1>
<?php
    if( !empty( $messageOk ) )echo '<div class="messageSummary">'.$messageOk.'</div><br/>';
    if( !empty( $messageEr ) )echo '<div class="errorSummary">'.$messageEr.'</div><br/>';
?>
<table id="tableListItems">
    <tr>
        <th class="TLFId">№</th>
        <th>Дата</th>
        <th class="TLFName">Сад</th>
        <th>Стоимость</th>
        <th class="TLFAction"><?= Yii::t("page", "статус"); ?></th>
        <th></th>
    </tr>
<?php foreach( $trees as $tree ) : ?>
    <tr>
        <td><?= $tree->id ?></td>
        <td><?= $tree->date ? SiteHelper::getDateOnFormat( "", "d.m.Y", $tree->date ) : "-" ?></td>
        <td>
            <?= $tree->garden_id->country->name."<br/><a href=\"".SiteHelper::createUrl( "/gardens/places", array("id"=>$tree->garden_id->id) ) ."\" target=\"_blank\" title=\"описания сада\">".$tree->garden_id->name ?></a><br/>
            <?= "<a href=\"".SiteHelper::createUrl( "/gardens/place", array("id"=>$tree->place_id->id) ) ."\" target=\"_blank\" title=\"описания участка\">".$tree->place_id->name ?>,
            <?= "<a href=\"".SiteHelper::createUrl( "/gardens/tree", array("id"=>$tree->tree_type->id) ) ."\" target=\"_blank\" title=\"описания дерева\">".$tree->tree_type->name ?></a>
        </td>
        <td>
            $ <?= $tree->amount ?><br/>
        </td>
        <td>
            <?= $tree->status_id->name ?><br/>
        </td>
        <td>
            <a href="<?= SiteHelper::createUrl("/merchant/index", array( "id"=>$tree->id )) ?>">оплатить</a><br/>
            <a href="<?= SiteHelper::createUrl("/user/requests/orderdel", array( "id"=>$tree->id )) ?>">удалить</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<?php
    if( sizeof( $trees ) ==0 )
        echo '<div class="textAlignCenter">Yii::t("page", "Список пуст") );</div>';
?>
