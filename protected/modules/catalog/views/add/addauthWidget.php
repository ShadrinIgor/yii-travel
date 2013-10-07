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
    <h1>Добавление объявления</h1>
    <p>
        Для добавлния объвления необходимо авторизоватся.
    </p>
    <?php $this->widget( "authWidget"); ?>
</div>