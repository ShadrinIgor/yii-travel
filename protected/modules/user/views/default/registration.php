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
        'links'=>array( Yii::t("user", "Регистрация" ) ),
    ));
?>
<?php echo CHtml::form('user/default/registration/','post',array('enctype'=>'multipart/form-data', 'id'=>'validateForm')); ?>
<h1><?= $title ?></h1>
    <?php if( empty($okMessage) ) : ?>
        <div class="messageSummary">
            <?php
            $text = CatalogContent::fetchBySlug( "after_registration" );
            echo $text->description;
            ?>
        </div>
        <br/>
    <?php endif; ?>
<?php echo CHtml::errorSummary($form); ?>
<?php if(!empty($okMessage) ) : ?>
    <div class="messageSummary"><p><?= $okMessage ?></p></div>
<?php else: ?>
    <table border="0" width="500" cellpadding="6" cellspacing="6" class="tableForm">
        <?= CCModelHelper::addForm( $form, true, $this ) ?>
        <tr class="trNoBorder">
            <td></td>
            <td>
                <?php echo CHtml::activeCheckBox($form, 'term'); ?>&nbsp;
                <?php echo CHtml::activeLabel($form, Yii::t("user", 'С' ) ); ?>&nbsp;<?php echo CHtml::link( Yii::t("user", 'правилами' ), SiteHelper::createUrl("/user/default/term"), array("target"=>"_blank")); ?>&nbsp;<?php echo CHtml::activeLabel($form, ' '.Yii::t("user", 'согласен') ); ?>
                <?php echo CHtml::submitButton( Yii::t("user", 'Зарегистрироваться') ); ?></td>
        </tr>
    </table>
<?php endif; ?>
<?php echo CHtml::endForm(); ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
</div>