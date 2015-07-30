<?php
$baseUrl=$Theme->getBaseUrl();
$this->listJsFiles[] = $baseUrl.'/js/jquery/jquery.validationEngine-ru.js';
$this->listJsFiles[] = $baseUrl.'/js/jquery/jquery.validationEngine.js';
$this->listCssFiles[] = $baseUrl.'/css/jquery/validationEngine.jquery.css';
?>

<div id="PageText">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array( Yii::t("user", "Авторизация" ) ),
    ));
    ?>
    <div class="well">
        <div class="panel panel-success well-margin-auto">
            <?php echo CHtml::form('','post',array( 'id'=>'validateForm')); ?>
            <?php echo CHtml::errorSummary($form); ?><br>
            <?php $controller->widget("authWidget") ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>