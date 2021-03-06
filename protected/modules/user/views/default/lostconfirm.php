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
        'links'=>array( Yii::t("user", "Смена пароля" ) ),
    ));
    ?>
    <!--php Yii::app()->banners->getBannerByCategory( 1 ); ?-->
    <?php echo CHtml::form( SiteHelper::createUrl("default/LostConfirm/", array("key"=>Yii::app()->request->getParam("key", ""))), 'post',array( 'id'=>'validateForm')); ?>
    <h1><?= Yii::t("user", "Смена пароля") ?></h1>
    <?php echo CHtml::errorSummary($form); ?><br>
    <?php if( $error ) : ?>
        <div class="errorSummary">
            <p>
                <b><?= Yii::t("user", "Ошибка" ) ?></b>
                <ul><li><?= Yii::t("user", "Вы перешли по не рабочей ссылке." ) ?></li></ul>
            </p>
        </div>
    <?php elseif( $okMessage ) : ?>
        <div class="messageSummary">
            <p>
                <b><?= Yii::t("user", "Поздравляем" ) ?></b>
                <?= $okMessage ?>
            </p>
        </div>
    <?php else : ?>
        <?php echo CHtml::errorSummary($formNewsPassword); ?><br>
        <table class="tableForm" align="center">
            <tr>
                <th><?php echo CHtml::activeLabel($formNewsPassword, 'password'); ?><font class="redColor">*</font></th>
                <td><?php echo CHtml::activePasswordField($formNewsPassword, 'password', array( 'class'=>'validate[required]' )) ?></td>
            </tr>
            <tr>
                <th><?php echo CHtml::activeLabel($formNewsPassword, 'password2'); ?><font class="redColor">*</font></th>
                <td><?php echo CHtml::activePasswordField($formNewsPassword, 'password2', array( 'class'=>'validate[required]' )) ?></td>
            </tr>
            <tr>
                <td></td>
                <td align="center">
                    <?php
                        echo CHtml::submitButton( Yii::t("user", "Сохранить" ));
                    ?>
                </td>
            </tr>
        </table>
        <?php echo CHtml::endForm(); ?>
    <?php endif; ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
</div>