<div id="PageText">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array( Yii::t("user", "Персональный кибинет") ),
    ));
    ?>
    <h1><?= Yii::t("user", "Персональный кабинет") ?></h1>
    <p align="center">
        <?= Yii::t("user", "Вы успешно авторизовались. Теперь для Вас доступны все возможности персонального кабинета."); ?><br/>
        <img src="<?= $Theme->getBaseUrl() ?>/images/strelkapng.jpg" />
    </p>
    <br/><br/>
    <h2><?= Yii::t("user", "МЫ РЕКОМЕНДУЕМ"); ?></h2>
    <div class="textAlignCenter">
        <a href="<?= SiteHelper::createUrl("/site/page") ?>/besplatniy-reklamnyi-banner" class="addButton" title="<?= Yii::t("user", "Разместить бесплатный баннер на сайте"); ?>"><?= Yii::t("user", "Разместить бесплатный баннер на сайте"); ?></a>
        <br/>
        <a href="<?= SiteHelper::createUrl("/user/firms/description") ?>" class="addButton" title="+ <?= Yii::t("user", "Добавить туристическую фирму"); ?>">+ <?= Yii::t("user", "Добавить фирму"); ?></a>
        <a href="<?= SiteHelper::createUrl("/user/resort") ?>" class="addButton" title="+ <?= Yii::t("user", "Добавить зону отдыха/детский лагерь"); ?>">+ <?= Yii::t("user", "Добавить зону отдыха/детский лагерь"); ?></a>
        <a href="<?= SiteHelper::createUrl("/user/hotels") ?>" class="addButton" title="+ <?= Yii::t("user", "Добавить Отель"); ?>">+ <?= Yii::t("user", "Добавить Отель"); ?></a>
        <br/>
        <a href="<?= SiteHelper::createUrl("/user/work") ?>" class="addButton" title="+ <?= Yii::t("user", "Добавить вакансию"); ?>">+ <?= Yii::t("user", "Добавить вакансию"); ?></a>
        <a href="<?= SiteHelper::createUrl("/user/resume") ?>" class="addButton" title="+ <?= Yii::t("user", "Добавить резюме"); ?>">+ <?= Yii::t("user", "Добавить резюме"); ?></a>
    </div>
</div>