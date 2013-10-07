<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Добавить в горяиче" ),
    ));
?>
<h1><?= $serviceModel->name ?></h1>
<?= $serviceModel->description ?>
    <form action="" method="post">
        <?php if( !empty($error)) : ?>
            <div class="errorSummary"><?= $error ?></div>
        <?php endif; ?>
    <div class="centerInfo">
    <table>
        <tr>
            <th>Объявление:</th>
            <td><?= $item->name ?></td>
        </tr>
        <tr>
            <th>Стоимость услуги:</th>
            <td>$<?= $serviceModel->price ?></td>
        </tr>
        <tr>
            <th>Состояние счета:</th>
            <td>$<?= UserHelper::getAmount() ?></td>
        </tr>
        <tr>
            <td colspan="2" class="textAlignCenter">
                <?php if( UserHelper::getAmount() >= $serviceModel->price ) : ?>
                        <input type="submit" name="pay_order" value="Оплатить" />
                <?php else : ?>
                    <b class="red">У вас не хватает средств для оплаты.</b><br/><a href="<?= SiteHelper::createUrl("/user/fprofile/recharge") ?>">Пополнить счет?</a>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    </div>
    </form>
</div>
