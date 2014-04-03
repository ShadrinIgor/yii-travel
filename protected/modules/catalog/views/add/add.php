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
        'links'=>array( "добавление объявления" ),
    ));
    ?>
    <?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data', 'id'=>'validateForm')); ?>
    <h1>Добавление объявления</h1>
    <?php echo CHtml::errorSummary($form); ?><br>
    <?php if(!empty($okMessage) ) : ?><div class="messageSummary"><p><?= $okMessage ?></p></div><?php endif;?>
    <div class="messageSummary"><p>После добавления объявления, Вы сможете прикрепить фотографии к объявлению. Для публикации объявления необходимо опубликовать минимум 6 фотографий.</p></div>
    <table border="0" width="600" cellpadding="6" cellspacing="6" class="tableForm">
        <?= CCModelHelper::addForm( $form ) ?>
        <tr>
            <td colspan="2">
                <table border="0" id="addFormDopParam" width="500" cellpadding="6" cellspacing="6" class="tableForm<?= ( empty( $addDopParams ) ) ? " displayNone" : "" ?>">
                    <?php if( !empty( $addDopParams ) ) : ?>
                        <?= CCModelHelper::addForm( $addDopParams ) ?>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
        <tr class="trNoBorder">
            <td></td>
            <td><?php echo CHtml::submitButton('Сохранить', array("name"=>"save_profile")); ?></td>
        </tr>
    </table>
    <?php echo CHtml::endForm(); ?>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
</div>