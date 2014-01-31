<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Добавление информации"
    )
));
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
        1
    </div>
    <div id="tcurorts_page" class="pageTab<?= $activeTab == "tcurorts" ? " activePage " : " displayNone" ?>">
        <h1>Добавление курортов/зон отдыха</h1>
        2
    </div>
    <div id="thotels_page" class="pageTab<?= $activeTab == "thotels" ? " activePage " : " displayNone" ?>">
        <h1>Добавление гостиницы</h1>
        3
    </div>
    <div id="tvakansi_page" class="pageTab<?= $activeTab == "tvakansi" ? " activePage " : " displayNone" ?>">
        <h1>Добавление вакансий/резюме</h1>
        4
    </div>
    <div id="titems_page" class="pageTab<?= $activeTab == "titems" ? " activePage " : " displayNone" ?>">
        <h1>Добавление частных объявлений</h1>
        5
    </div>
</div>