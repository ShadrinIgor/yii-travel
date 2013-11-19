<?php if( Yii::app()->user->isGuest ) : ?>
<div id="authForm">
    <?php echo CHtml::form('/user','post',array( 'id'=>'validateForm')); ?>
    <h1>Авторизация</h1>
    <table id="loginForm" align="center">
        <tr>
            <th width="150"><?php echo CHtml::activeLabel($form, 'email'); ?><font class="redColor">*</font></th>
            <td><input class="validate[required,custom[email]]" name="CatalogUsersAuth[email]" id="CatalogUsersAuth_email" type="text"></td>
        </tr>
        <tr>
            <th><?php echo CHtml::activeLabel($form, 'password'); ?><font class="redColor">*</font></th>
            <td><input class="validate[required]" name="CatalogUsersAuth[password]" id="CatalogUsersAuth_password" type="password" maxlength="255"></td>
        </tr>
        <tr>
            <td></td>
            <td align="left">
                <input type="submit" name="yt0" value="Авторизоватся">
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">
                <?php echo CHtml::link("Регистрация", SiteHelper::createUrl( "/user/default/Registration" ) ); ?><br/>
                <?php echo CHtml::link("Забыли пароль", SiteHelper::createUrl( "/user/default/lost" )  ); ?>
            </td>
        </tr>
    </table>
    </form>
<?php endif; ?>
</div>