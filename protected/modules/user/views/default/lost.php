<?php
$cs=Yii::app()->clientScript;
$cs->scriptMap=array();
$baseUrl=$Theme->getBaseUrl();
$cs->registerScriptFile($baseUrl.'/js/jquery/jquery.js');
$cs->registerScriptFile($baseUrl.'/js/jquery/jquery.validationEngine-ru.js');
$cs->registerScriptFile($baseUrl.'/js/jquery/jquery.validationEngine.js');
$cs->registerCssFile($baseUrl.'/css/jquery/validationEngine.jquery.css');
?>

<div id="PageText">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Востановление пароля" ),
    ));
    ?>

    <?php echo CHtml::form('','post',array( 'id'=>'validateForm')); ?>
    <h1>Востановление пароля</h1>
    <?php echo CHtml::errorSummary($form); ?><br/>
    <?php if(!empty($okMessage) ) : ?><div class="messageSummary"><p><?= $okMessage ?></p></div><?php endif;?>
    <table id="loginForm" align="center">
        <tr>
            <th width="150"><?php echo CHtml::activeLabel($form, 'email'); ?><font class="redColor">*</font></th>
            <td><?php echo CHtml::activeTextField($form, 'email', array( 'class'=>'validate[required,custom[email]]' )) ?></td>
        </tr>
        <tr>
            <td></td>
            <td align="center">
                <?php echo CHtml::button('Отмена', array("id"=>"lost_cansel", "onclick"=>"document.location.assign('".SiteHelper::createUrl("/user")."')")); ?>&nbsp;
                <?php echo CHtml::submitButton('Отправить запрос'); ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::endForm(); ?>
</div>