<div id="catalogItems">
    <h1><?= Yii::t("user", "Подтверждение регистрации" ) ?></h1>
    <?php if( !$error ) : ?>
        <div class="messageSummary">
            <p>
                <b><?= Yii::t("user", "Поздравляем" ) ?></b>
                <?= Yii::t("user", "Вы успешно зарегистрировались, авторизуйтесь используя указанные данные" ) ?>.
            </p>
        </div>
    <?php else : ?>
    <div class="errorSummary">
        <p>
            <b><?= Yii::t("user", "Ошибка" ) ?></b>
            <ul><li><?= Yii::t("user", "Вы перешли по не рабочей ссылке" ) ?>.</li></ul>
            <?= !empty( $errorMessage ) ? $errorMessage : "" ?>
        </p>
    </div>
    <?php endif; ?>
</div>