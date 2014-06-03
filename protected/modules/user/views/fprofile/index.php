<?php
$this->widget('addressLineWidget', array(
    'links'=>array( "Финансовый профиль" ),
));
?>
<h1>Финансовый профиль</h1>
<div class="overflowHidden">
    <div id="userAmount">
        $<?= UserHelper::getAmount( $user ) ?>
    </div>
    <div class="floatLeft">
        <a href="<?= SiteHelper::createUrl("/user/fprofile/recharge") ?>">Пополнить счет</a><br/>
        <a href="<?= SiteHelper::createUrl("/user/requests") ?>">Все заказы</a>
    </div>
</div>
<div class="overflowHidden">
    <h2>Финансовая история</h2>
    <table id="tableListItems">
        <tr>
            <th class="TLFId">№</th>
            <th><?= Yii::t("user", "Дата") ?></th>
            <th>Описание заказа</th>
            <th class="TLFAction"><?= Yii::t("page", "статус"); ?></th>
            <th>Сумма</th>
        </tr>
        <?php
        $tottalAmount=0;
        /*
            $tottalAmount = 0;
            foreach( $orders as $tree ) :
                $amountTitle = (( $tree->type_id->id == 4 ) ? "+" : "-" ) ." $". $tree->amount;

                if( $tree->status_id && $tree->status_id->id == 2 || $tree->status_id->id == 3 )
                {
                    if( $tree->type_id->id == 4 )$tottalAmount += $tree->amount;
                                            else $tottalAmount -= $tree->amount;

                    $amountTitle = "<b>".(( $tree->type_id->id == 4 ) ? "+" : "-" ) ." $". $tree->amount."</b>&nbsp;";
                }
                   else $amountTitle = "<i> $". $tree->amount."&nbsp;</i>";
            ?>
            <tr>
                <td><?= $tree->id ?></td>
                <td><?= $tree->date ? SiteHelper::getDateOnFormat( $tree->date, "d.m.Y" ) : "-" ?></td>
                <td>
                    <?= $tree->type_id->name ?>
                </td>
                <td>
                    <?= $tree->status_id->name ?><br/>
                    <?= $tree->status_id->id == 1 ? '<a href="'.SiteHelper::createUrl("/merchant/index", array("id"=>$tree->id)).'">оплатить</a>' : "" ?>
                </td>
                <td class="textAlignRight">
                    <?= $amountTitle ?><br/>
                </td>
            </tr>
        <?php endforeach; */ ?>
        <tr>
            <td colspan="5"><div class="textAlignCenter">Списк пуст</div></td>
        </tr>
        <tr>
            <td colspan="4">Итого: </td>
            <th class="textAlignRight">$<?= $tottalAmount ?></th>
        </tr>
    </table>
<?php
if( sizeof( $orders ) ==0 )
    echo '<div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div>';
?>
</div>