<div class="panel panel-success">
    <div class="panel-heading">
        <?= Yii::t("form", "Вам кажется что не хватает информации?"); ?>
    </div>
    <div class="panel-body">
            <?= Yii::t("form", "Если Вам кажется что не хватает каких то полей, либо поля формы не содержат необходимых значений"); ?>.<br/>
            <?= Yii::t("form", "Напишите свое предложение на email поддержки"); ?> - <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, <?= Yii::t("form", "и распишите свое предложение, мы обязательно его рассмотрим"); ?>.
    </div>
</div>
<div  class="panel panel-warning">
    <div class="panel-heading">
        ВНИМАНИЕ!!!
    </div>
    <div class="panel-body">
        <?= Yii::t("form", "Если произошла непонятная/некорректная ошибка при сохранении формы, напишите в техническую поддержку, мы обязательно Вам поможем"); ?> - <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>.
    </div>
</div>
