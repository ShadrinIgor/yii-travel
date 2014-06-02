<?php
$cs=Yii::app()->clientScript;
$cs->scriptMap=array();
$baseUrl=$Theme->getBaseUrl();
$cs->registerScriptFile($baseUrl.'/js/jquery/jquery.js');
$cs->registerScriptFile($baseUrl.'/js/jquery/jquery.validationEngine-ru.js');
$cs->registerScriptFile($baseUrl.'/js/jquery/jquery.validationEngine.js');
$cs->registerCssFile($baseUrl.'/css/jquery/validationEngine.jquery.css');

$cs->registerScriptFile($baseUrl.'/js/chosen/chosen.jquery.js');
$cs->registerCssFile($baseUrl.'/js/chosen/chosen.css');
?>

<div id="PageText">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array( Yii::t("user", "Персональная информация" ) ),
    ));
    ?>
    <?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data', 'id'=>'validateForm')); ?>
    <h1><?= Yii::t("user", "Персональная информация" ) ?></h1>
    <?= CHtml::errorSummary($form); ?><br/>
    <?= $form->getMessage() ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"profileNote" ) ) ?>
    <table border="0" width="500" cellpadding="6" cellspacing="6" class="tableForm">
       <?= CCModelHelper::addForm( $form ) ?>
        <tr class="trNoBorder">
            <td></td>
            <td><?php echo CHtml::submitButton( Yii::t("user", 'Сохранить'), array("name"=>"save_profile")); ?></td>
        </tr>
    </table>
    <?php echo CHtml::endForm(); ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
</div>