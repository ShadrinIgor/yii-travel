<?php if( Yii::app()->user->isGuest ) : ?>
<div id="authForm">
    <?php echo CHtml::form('/user','post',array( 'id'=>'validateForm')); ?>
    <div style="text-align:center;"><b>Авторизация</b></div>
    <table id="loginForm" align="center">
        <?=
            CCModelHelper::addForm( $form, true, Yii::app()->controller )
        ?>
        <tr>
            <td></td>
            <td align="left">
                <input type="submit" name="yt023" value="Авторизоватся">
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