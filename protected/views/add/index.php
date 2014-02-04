<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Добавление информации"
    )
));
?>

<?php
if( $this->beginCache("addPage", array('duration'=>3600) ) ):
    $firm = CatalogContent::fetchByKeyWord("add_firm");
    $kurorts = CatalogContent::fetchByKeyWord("add_kurorts");
    $hotels = CatalogContent::fetchByKeyWord("add_hotels");
    $vacansy = CatalogContent::fetchByKeyWord("add_vacansy");
    $items = CatalogContent::fetchByKeyWord("add_items");
?>

<div id="InnerText" class="innerPage">
    <div id="dopMenu">
        <a href="#" id="tfirm" class="<?= $activeTab == "tfirm" ? "activeDM " : "" ?>dopMenuPages">Добавление фирмы<br/>&nbsp;</a>
        <a href="#" id="tcurorts" class="<?= $activeTab == "tcurorts" ? "activeDM " : "" ?>dopMenuPages">Добавление курортов/зон отдыха</a>
        <a href="#" id="thotels" class="<?= $activeTab == "thotels" ? "activeDM " : "" ?>dopMenuPages">Добавление гостиницы<br/>&nbsp</a>
        <a href="#" id="tvakansi" class="<?= $activeTab == "tvakansi" ? "activeDM " : "" ?>dopMenuPages">Добавление вакансий/резюме<br/>&nbsp</a>
        <a href="#" id="titems" class=<?= $activeTab == "titems" ? "activeDM " : "" ?>"dopMenuPages">Добавление частных объявлений</a>
    </div>
    <br/>
    <div id="tfirm_page" class="pageTab<?= $activeTab == "tfirm" ? " activePage " : " displayNone" ?>">
        <h1>Добавление фирмы</h1>
        <?= $firm->description; ?>
        <br/>
        Для добавления туристической фирмы перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/firms") ?>" title="Добавить туристическую фирму бесплатно"><?= SiteHelper::createUrl("/user/firms") ?></a>
    </div>
    <div id="tcurorts_page" class="pageTab<?= $activeTab == "tcurorts" ? " activePage " : " displayNone" ?>">
        <h1>Добавление курортов/зон отдыха</h1>
        <?= $kurorts->description; ?>
        <br/>
        Для добавления зоны отдыха/курорта перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/resort") ?>" title="Добавить зону отдыха/курорт бесплатно"><?= SiteHelper::createUrl("/user/resort") ?></a>
    </div>
    <div id="thotels_page" class="pageTab<?= $activeTab == "thotels" ? " activePage " : " displayNone" ?>">
        <h1>Добавление гостиницы</h1>
        <?= $hotels->description; ?>
        <br/>
        Для добавления гостиницы перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/hotels") ?>" title="Добавить гостиницы бесплатно"><?= SiteHelper::createUrl("/user/hotels") ?></a>
    </div>
    <div id="tvakansi_page" class="pageTab<?= $activeTab == "tvakansi" ? " activePage " : " displayNone" ?>">
        <h1>Добавление вакансий/резюме</h1>
        <?= $vacansy->description; ?>
        <br/>
        Для добавления вакансии перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/work") ?>" title="Добавить вакансию фирму бесплатно"><?= SiteHelper::createUrl("/user/work") ?></a><br/>
        Для добавления резюме перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/work") ?>" title="Добавить резюме фирму бесплатно"><?= SiteHelper::createUrl("/user/resume") ?></a>
    </div>
    <div id="titems_page" class="pageTab<?= $activeTab == "titems" ? " activePage " : " displayNone" ?>">
        <h1>Добавление частных объявлений</h1>
        <?= $items->description; ?>
        <br/>
        Для добавления частных объявлений перейдите по ссылке <a href="<?= SiteHelper::createUrl("/user/items") ?>" title="Добавить частных объявлений на доске объявлений бесплатно"><?= SiteHelper::createUrl("/user/items") ?></a>
    </div>
    <div class="greeBorder">
        <b>Внимание!!!</b><br/>
        При переходе Вам необходимо будет авторизоватся, либо зарегестрироваться если у вас нет логина. После этого Вы сможете вносить информацию.<br/>
        <br/>
        <b>Возникли вопросы?</b><br/>
        Пишите нам на емаил <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>, мы будем рады на них ответить.
    </div>
</div>

<?php
    $this->endCache();
    endif;
?>