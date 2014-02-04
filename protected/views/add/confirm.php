<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Подтверждение информации"
    )
));
?>

<?php
//if( $this->beginCache("addPage", array('duration'=>3600) ) ):
    $firm = CatalogContent::fetchByKeyWord("add_confirm");
?>

<div id="InnerText" class="innerPage">
    <h1>Подтверждение информации</h1>
    <?= $firm->description; ?>
    <br/>

    <div class="greeBorder">
        <b>Возникли вопросы?</b><br/>
        Пишите нам на емаил <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, мы будем рады на них ответить.
    </div>
</div>

<?php
  //  $this->endCache();
   // endif;
?>