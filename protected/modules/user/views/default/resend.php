<div id="catalogItems">
    <h1><?= Yii::t("user", "Подтверждение регистрации" ) ?></h1>
    <?php echo CHtml::errorSummary($user); ?><br>
    <div class="messageSummary">
        <p>
            <?= Yii::t("user", "На Ваш Email заново отправленно письмо для подтверждения регистрации." ) ?>
        </p>
    </div>
</div>