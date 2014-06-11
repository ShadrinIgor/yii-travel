<?php
$baseUrl=$Theme->getBaseUrl();
$this->listJsFiles[] = $baseUrl.'/js/jquery/jquery.validationEngine-ru.js';
$this->listJsFiles[] = $baseUrl.'/js/jquery/jquery.validationEngine.js';
$this->listCssFiles[] = $baseUrl.'/css/jquery/validationEngine.jquery.css';
?>

<div id="PageText">

    <?php echo CHtml::form('','post',array( 'id'=>'validateForm')); ?>
    <h1>Авторизация</h1>
    <?php echo CHtml::errorSummary($form); ?><br>
    <table id="loginForm" align="center">
        <tr>
            <td colspan="2" align="center">
                <table>
                    <?= CCModelHelper::addForm( $form, true, $this ) ?>
                <tr>
                    <td></td>
                    <td align="left">
                        <?php echo CHtml::submitButton('авторизоваться'); ?>
                    </td>
                </tr>
                    <tr>
                        <td></td>
                        <td align="left">
                            <?php echo CHtml::link("Регистрация", SiteHelper::createUrl( "/user/default/Registration" ) ); ?>&nbsp;&nbsp;
                            <?php echo CHtml::link("Забыли пароль", SiteHelper::createUrl( "/user/default/lost" )  ); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php echo CHtml::endForm(); ?>
</div>