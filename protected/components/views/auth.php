<?php if( Yii::app()->user->isGuest ) : ?>
<div id="authForm">
    <?php echo CHtml::form('/user','post',array( 'id'=>'validateForm')); ?>
    <h1>Авторизация</h1>
    <table id="loginForm" align="center">
        <?=
            CCModelHelper::addForm( $form, true, Yii::app()->controller )
        ?>
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