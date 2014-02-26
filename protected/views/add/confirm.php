<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Подтверждение информации"
    )
));
?>

<?php
//if( $this->beginCache("addPage", array('duration'=>3600) ) ):
    $firm = CatalogContent::fetchBySlug("add_confirm");
?>

<div id="InnerText" class="innerPage">
    <h1>Подтверждение информации</h1>
    <?= $firm->description; ?>
    <br/>

    <div class="greeBorder">
        <p>
            <b>Возникли вопросы?</b><br/>
            Пишите нам на емаил <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, мы будем рады на них ответить.
        </p>
        <p>
            <b>Вы работает в туристической фирме? Хотите разместить рекламу БЕСПЛАТНО?</b><br/>
            вы можете БЕСПЛАТНО добавить инфомацию о Вашей туристической фирме, о вашем отеле, зоне отдыха <br>
            Например: Ваши услуги, рекламный баннер, туры, спец предложениея, акции... <br>
            <a href="<?= SiteHelper::createUrl("/add") ?>" title="Добавить туристическую информаци бесплатно">Добавить туристическую информаци бесплатно</a>
        </p>
    </div>
</div>

<?php
  //  $this->endCache();
   // endif;
?>