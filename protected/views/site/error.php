<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="pageError">
    <div>
        <h2>УПС... <?php echo $code; ?></h2>
        <?php echo CHtml::encode($message); ?>
    </div>
</div>
<br/>
<div class="greeBorder">
    <?= Yii::t("page", "Если произошла непонятная/некорректная ошибка напишите в техническую поддержку, мы обязательно Вам поможем"); ?> - <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>.<br/>
    <?= Yii::t("page", "P.S. При обращении обязательно укажите адрес страницы и условия при которых произошла ошибка."); ?>
</div>