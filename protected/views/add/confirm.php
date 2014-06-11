<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("add", "Подтверждение информации")
    )
));
?>

<?php
//if( $this->beginCache("addPage", array('duration'=>3600) ) ):
    $firm = CatalogContent::fetchBySlug("add_confirm");
?>

<div id="InnerText" class="innerPage">
    <h1><?= Yii::t("add", "Подтверждение информации"); ?></h1>
    <?= $firm->description; ?>
    <br/>

    <div class="greeBorder">
        <p>
            <b><?= Yii::t("add", "Возникли вопросы?"); ?></b><br/>
            <?= Yii::t("add", "Пишите нам на Email support@world-travel.uz, мы будем рады на них ответить."); ?>
        </p>
        <p>
            <b><?= Yii::t("add", "Вы работает в туристической фирме? Хотите разместить рекламу БЕСПЛАТНО?"); ?></b><br/>
            <?= Yii::t("add", "вы можете БЕСПЛАТНО добавить информацию о Вашей туристической фирме, о вашем отеле, зоне отдыха"); ?><br>
            <?= Yii::t("add", "Например: Ваши услуги, рекламный баннер, туры, спец предложения, акции... "); ?><br>
            <a href="<?= SiteHelper::createUrl("/add") ?>" title="<?= Yii::t("add", "Добавить туристическую информацию бесплатно"); ?>"><?= Yii::t("add", "Добавить туристическую информацию бесплатно"); ?></a>
        </p>
    </div>
</div>

<?php
  //  $this->endCache();
   // endif;
?>