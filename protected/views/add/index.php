<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        $activeTitle
    )
));
?>

<?php
    $firm = CatalogContent::fetchByKeyWord("add_firm");
    $kurorts = CatalogContent::fetchByKeyWord("add_kurorts");
    $hotels = CatalogContent::fetchByKeyWord("add_hotels");
    $vacansy = CatalogContent::fetchByKeyWord("add_vacansy");
    $items = CatalogContent::fetchByKeyWord("add_items");
    $otherInfo = CatalogContent::fetchByKeyWord("other-info");
?>

<div id="InnerText" class="innerPage">
    <h1>Бесплатное добавление туристической информации на сайт</h1>
    <div id="dopMenu">
        <a href="#" id="travel-agency" class="<?= $activeTab == "travel-agency" ? "activeDM " : "" ?>dopMenuPages">Добавление фирмы<br/>&nbsp;</a>
        <a href="#" id="curorts" class="<?= $activeTab == "curorts" ? "activeDM " : "" ?>dopMenuPages">Добавление курортов/зон отдыха</a>
        <a href="#" id="hotels" class="<?= $activeTab == "hotels" ? "activeDM " : "" ?>dopMenuPages">Добавление гостиницы<br/>&nbsp</a>
        <a href="#" id="vacancy-resume" class="<?= $activeTab == "vacancy-resume" ? "activeDM " : "" ?>dopMenuPages">Добавление вакансий/резюме<br/>&nbsp</a>
        <a href="#" id="ads-items" class=<?= $activeTab == "ads-items" ? "activeDM " : "" ?>"dopMenuPages">Добавление частных объявлений</a>
        <a href="#" id="other-info" class=<?= $activeTab == "other-info" ? "activeDM " : "" ?>"dopMenuPages">Добавление прочей информация</a>
    </div>
    <br/>
    <div id="travel-agency_page" class="pageTab<?= $activeTab == "travel-agency" ? " activePage " : " displayNone" ?>">
        <h2>Добавление фирмы</h2>
        <?= $firm->description; ?>
        <br/>
        Для добавления туристической фирмы перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/firms") ?>" title="Добавить туристическую фирму бесплатно"><?= SiteHelper::createUrl("/user/firms") ?></a>
    </div>
    <div id="curorts_page" class="pageTab<?= $activeTab == "curorts" ? " activePage " : " displayNone" ?>">
        <h2>Добавление курортов/зон отдыха</h2>
        <?= $kurorts->description; ?>
        <br/>
        Для добавления зоны отдыха/курорта перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/resort") ?>" title="Добавить зону отдыха/курорт бесплатно"><?= SiteHelper::createUrl("/user/resort") ?></a>
    </div>
    <div id="hotels_page" class="pageTab<?= $activeTab == "hotels" ? " activePage " : " displayNone" ?>">
        <h2>Добавление гостиницы</h2>
        <?= $hotels->description; ?>
        <br/>
        Для добавления гостиницы перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/hotels") ?>" title="Добавить гостиницы бесплатно"><?= SiteHelper::createUrl("/user/hotels") ?></a>
    </div>
    <div id="vacancy-resume_page" class="pageTab<?= $activeTab == "vacancy-resume" ? " activePage " : " displayNone" ?>">
        <h2>Добавление вакансий/резюме</h2>
        <?= $vacansy->description; ?>
        <br/>
        Для добавления вакансии перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/work") ?>" title="Добавить вакансию фирму бесплатно"><?= SiteHelper::createUrl("/user/work") ?></a><br/>
        Для добавления резюме перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/work") ?>" title="Добавить резюме фирму бесплатно"><?= SiteHelper::createUrl("/user/resume") ?></a>
    </div>
    <div id="ads-items_page" class="pageTab<?= $activeTab == "ads-items" ? " activePage " : " displayNone" ?>">
        <h2>Добавление частных объявлений</h2>
        <?= $items->description; ?>
        <br/>
        Для добавления частных объявлений перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/items") ?>" title="Добавить частных объявлений на доске объявлений бесплатно"><?= SiteHelper::createUrl("/user/items") ?></a>
    </div>
    <div id="other-info_page" class="pageTab<?= $activeTab == "other-info" ? " activePage " : " displayNone" ?>">
        <h2>Прочая информация</h2>
        <?= $otherInfo->description; ?>
        <br/>
        Email для запроса: <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>
    </div>
    <div class="greeBorder">
        <p>
            <b>Внимание!!!</b><br/>
            При переходе Вам необходимо будет авторизоватся, либо зарегестрироваться если у вас нет логина. После этого Вы сможете вносить информацию.<br/>
        </p>
        <p>
            <b>Возникли вопросы?</b><br/>
            Пишите нам на емаил <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, мы будем рады на них ответить.
        </p>
        <p>
            <b>Ваша информация, фирма, отель или прочая информация уже размещене на сайте?</b><br/>
            Если Вы хотите изменить её или удалить, Вам необходимо <a href="<?= SiteHelper::checkedSlugName("/add/confirm") ?>" title="подтвердить информацию">подтвердить информацию</a>.
        </p>
    </div>
</div>

