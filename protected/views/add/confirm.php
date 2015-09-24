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
    <div class="pageTab"><?= $firm->description; ?></div>
    <br/>

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Yii::t("add", "Возникли вопросы?"); ?>
        </div>
        <div class="panel-body">
            <?= Yii::t("add", "Пишите нам на Email <a href='mailto:support@world-travel.uz'>support@world-travel.uz</a>, мы будем рады на них ответить."); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <?= Yii::t("add", "Вы работает в туристической фирме? Хотите разместить рекламу БЕСПЛАТНО?"); ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Yii::t("add", "вы можете БЕСПЛАТНО добавить информацию о Вашей туристической фирме, о вашем отеле, зоне отдыха"); ?><br>
                <?= Yii::t("add", "Например: Ваши услуги, рекламный баннер, туры, спец предложения, акции... "); ?><br>
                <a href="<?= SiteHelper::createUrl("/add") ?>" title="<?= Yii::t("add", "Добавить туристическую информацию бесплатно"); ?>"><?= Yii::t("add", "Добавить туристическую информацию бесплатно"); ?></a>
            </p>
        </div>
    </div>
</div>

<?php
  //  $this->endCache();
   // endif;
?>