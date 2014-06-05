<h2><?= Yii::t("trainings", "Мы Вам рекомендуем"); ?></h2>
<?php if( $type_id == 1 ) : ?>
    <a href="<?= SiteHelper::createUrl( "/user/firms/description" ) ?>" class="addButton" title="+ <?= Yii::t("trainings", "Добавить туристическую фирму"); ?>"><?= Yii::t("trainings", "Добавить свою тур фирму"); ?></a>
<?php endif; ?>
<?php if( $type_id == 4 ) : ?>
    <a href="<?= SiteHelper::createUrl( "/user/hotels/description" ) ?>" class="addButton" title="+ <?= Yii::t("trainings", "Добавить Отель"); ?>"><?= Yii::t("trainings", "Добавить Отель"); ?></a>
<?php endif; ?>
<?php if( $type_id == 5 ) : ?>
    <a href="<?= SiteHelper::createUrl( "/user/hotels/resort" ) ?>" class="addButton" title="+ <?= Yii::t("trainings", "Добавить зону отдыха/детский лагерь"); ?>"><?= Yii::t("trainings", "Добавить ЗОНУ ОТДЫХА или ДЕТСКИЙ ЛАГЕРЬ"); ?></a>
<?php endif; ?>
<br/>
<a href="<?= SiteHelper::createUrl( "/site/sales" ) ?>" class="addButton" title="<?= Yii::t("trainings", "Разместить Акцию/Скидку/Спец. предложение компании"); ?>"><?= Yii::t("trainings", "Разместить Акцию/Скидку компании"); ?></a>
<br/>
<a href="<?= SiteHelper::createUrl( "/site/page" ) ?>/besplatniy-reklamnyi-banner" class="addButton" title="<?= Yii::t("trainings", "Разместить бесплатный баннер на сайте"); ?>"><?= Yii::t("trainings", "Разместить бесплатный баннер на сайте"); ?></a>
<br/>
<br/>
<br/>
<div class="textAlignCenter">
    <a href="#" class="trainingsLast"><?= Yii::t("page", "Назад"); ?></a>&nbsp;|&nbsp;
    <a href="#" class="trainingsClose"><?= Yii::t("trainings", "Закрыть подсказку"); ?></a>&nbsp;|&nbsp;
    <a href="#" class="trainingsCloseGroup"><?= Yii::t("trainings", "Больше не напоминать"); ?></a>
</div>