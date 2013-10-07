<?php

$this->widget('addressLineWidget', array(
    'links'=>array( "Оплата заказа" ),
));

?>

<!-- https://www.paypal.com/cgi-bin/webscr -->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <h1>Оплата заказа №<?= $model->id ?></h1>
   <div style="text-align: justify;width: 100%;">На этой странице Вы можете оплатить online Ваш заказ.</div><br><br>
    <div class="merchantTable">
    <table>
        <tbody><tr>
            <td>Платежная система</td>
            <td>
                <input type="radio" name="merchant_operator" value="paypal" id="paypal" checked="checked" /><label for="paypal">PayPal</label>
            </td>
        </tr>
        <tr>
            <td class="MTNoBorder">Итого к оплате* (в $ USD)</td>
            <td class="MTNoBorder MPrice">$<?= $model->amount ?></td>
        </tr>
        <tr>
            <td class="MTNoBorder" colspan="2" align="right">
                <input name="amount" type="hidden" value="<?= 5;//$model->amount ?>" />
                <input name="cmd" type="hidden" value="_xclick" />
                <input name="business" type="hidden" value="mygreenlegacy@gmail.com" />
                <input name="item_name" type="hidden" value="Payment of invoice" />
                <input name="item_number" type="hidden"  value="<?= $model->id ?>" />
                <input name="no_shipping" type="hidden" value="1" />
                <input name="rm" type="hidden" value="0" />
                <input name="return" type="hidden" value="<?= SiteHelper::createUrl("/merchant/return" ) ?>" />
                <input name="cancel_return" type="hidden" value="<?= SiteHelper::createUrl("/merchant/cansel" ) ?>" />
                <input name="notify_url" type="hidden" value="<?= SiteHelper::createUrl( "/merchant/notify" ) ?>" />
                <input name="currency_code" type="hidden" value="USD" />
<!--
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="first_name" value="John">
<input type="hidden" name="last_name" value="Doe">
<input type="hidden" name="address1" value="9 Elm Street">
<input type="hidden" name="address2" value="Apt 5">
<input type="hidden" name="city" value="Berwyn">
<input type="hidden" name="state" value="PA">
<input type="hidden" name="zip" value="19312">
<input type="hidden" name="night_phone_a" value="610">
<input type="hidden" name="night_phone_b" value="555">
<input type="hidden" name="night_phone_c" value="1234">
<input type="hidden" name="email" value="jdoe@zyzzyu.com">
<input type="image" name="submit" border="0"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">
</form>
-->
                <input type="button" name="cansel" onclick="window.location='<?= SiteHelper::createUrl("/user/fprofile") ?>';" value="Отмена" />&nbsp;
                <input style="margin: :0px;" type="submit" value="Далее" name="register_submit_button">
            </td>
        </tr>
        </tbody></table>
    </div>
</form>