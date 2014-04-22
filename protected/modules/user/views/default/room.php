<div id="PageText">
    <?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Персональный кибинет" ),
    ));
    ?>
    <h1>Персональный кабинет</h1>
    <p align="center">
        Вы успешно авторизовались. Теперь для Вас доступны все возможности персонального кабинета.<br/>
        <img src="<?= $Theme->getBaseUrl() ?>/images/strelkapng.jpg" />
    </p>
    <br/><br/>
    <h2>МЫ РЕКОМЕНДУЕМ</h2>
    <div class="textAlignCenter">
        <a href="<?= SiteHelper::createUrl("/site/page") ?>/besplatniy-reklamnyi-banner" class="addButton" title="Разместить бесплатный баннер на сайте">Разместить бесплатный баннер на сайте</a>
        <br/>
        <a href="<?= SiteHelper::createUrl("/user/firms/description") ?>" class="addButton" title="+ Добавить туристическую фирму">+ Добавить фирму</a>
        <a href="<?= SiteHelper::createUrl("/user/resort") ?>" class="addButton" title="+ Добавить зону отдыха/детский лагерь">+ Добавить зону отдыха/детский лагерь</a>
        <a href="<?= SiteHelper::createUrl("/user/hotels") ?>" class="addButton" title="+ Добавить Отель">+ Добавить Отель</a>
        <br/>
        <a href="<?= SiteHelper::createUrl("/user/work") ?>" class="addButton" title="+ Добавить вакансию">+ Добавить вакансию</a>
        <a href="<?= SiteHelper::createUrl("/user/resume") ?>" class="addButton" title="+ Добавить резюме">+ Добавить резюме</a>
    </div>
</div>