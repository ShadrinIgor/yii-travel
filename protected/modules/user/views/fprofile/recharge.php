<?php

$this->widget('addressLineWidget', array(
    'links'=>array( "Финансовый профиль"=> SiteHelper::createUrl("/user/fprofile"),
        "пополнение счета"
    ),
));

?>

<h1>Введите сумму пополнения</h1>
<?= !empty( $error ) ? '<div class="errorSummary">'.$error.'</div>' : "" ?>
<form action="<?= SiteHelper::createUrl( "/user/fprofile/recharge" ) ?>" method="post">
    <table border="0" width="500" cellpadding="6" cellspacing="6" class="tableForm">
        <tr>
            <th>Стоимость:</th>
            <td><b>$ <input type="input" name="price" /></b></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/user/fprofile" ) ?>'" name="cansel" value="<?= Yii::t("page", "Отмена") ?>" />&nbsp;
                <input type="submit" name="recharge_submit" value="Отправить" /></td>
        </tr>
    </table>
</form>

