<div id="innerPage">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            Yii::t("user", "Мои сообщения") => SiteHelper::createUrl( "/user/messages" ),
            $item->subject
        ),
    ));
    ?>
    <h1><?= $item->subject ?></h1>
    <p>
        <?= Yii::t("user", "Дата") ?> : <b><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y H:i" ) ?></b>
    </p>
    <?= $item->message ?>
</div>