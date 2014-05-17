<h2>Мы Вам рекомендуем</h2>
<?php if( $type_id == 1 ) : ?>
    <a href="<?= SiteHelper::createUrl( "/user/firms/description" ) ?>" class="addButton" title="+ Добавить туристическую фирму">+ Добавить свою тур фирму</a>
<?php endif; ?>
<?php if( $type_id == 4 ) : ?>
    <a href="<?= SiteHelper::createUrl( "/user/hotels/description" ) ?>" class="addButton" title="+ Добавить Отель">+ Добавить Отель</a>
<?php endif; ?>
<?php if( $type_id == 5 ) : ?>
    <a href="<?= SiteHelper::createUrl( "/user/hotels/resort" ) ?>" class="addButton" title="+ Добавить зону отдыха/детский лагерь">+ Добавить ЗОНУ ОТДЫХА или ДЕТСКИЙ ЛАГЕРЬ</a>
<?php endif; ?>
<br/>
<a href="<?= SiteHelper::createUrl( "/site/page" ) ?>/besplatniy-reklamnyi-banner" class="addButton" title="Разместить бесплатный баннер на сайте">Разместить бесплатный баннер на сайте</a>
<br/>
<br/>
<br/>
<div class="textAlignCenter">
    <a href="#" class="trainingsLast">Назад</a>&nbsp;|&nbsp;
    <a href="#" class="trainingsClose">Закрыть подсказку</a>&nbsp;|&nbsp;
    <a href="#" class="trainingsCloseGroup">Больше не напоминать</a>
</div>