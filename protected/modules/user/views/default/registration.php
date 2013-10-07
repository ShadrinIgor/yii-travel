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
        'links'=>array( "Регистрация" ),
    ));
?>
<?php echo CHtml::form('user/default/registration/','post',array('enctype'=>'multipart/form-data', 'id'=>'validateForm')); ?>
<h1><?= $title ?></h1>
    <div class="messageSummary">
        <?php
        $text = CatalogContent::fetchByKeyWord( "after_registration" );
        echo $text->description;
        ?>
    </div>
    <br/>
<?php echo CHtml::errorSummary($form); ?><br>
<?php if(!empty($okMessage) ) : ?><div class="messageSummary"><p><?= $okMessage ?></p></div><?php endif;?>

<table border="0" width="500" cellpadding="6" cellspacing="6" class="tableForm">
    <?= CCmodelHelper::addForm( $form, true, $this ) ?>
    <tr class="trNoBorder">
        <td></td>
        <td>
            <?php echo CHtml::activeCheckBox($form, 'term'); ?>&nbsp;
            <?php echo CHtml::activeLabel($form, 'С'); ?>&nbsp;<?php echo CHtml::link('правилами', SiteHelper::createUrl("/user/default/term"), array("target"=>"_blank")); ?>&nbsp;<?php echo CHtml::activeLabel($form, ' согласен'); ?>
            <?php echo CHtml::submitButton('Зарегистрироваться'); ?></td>
    </tr>
</table>
<?php echo CHtml::endForm(); ?>
</div>