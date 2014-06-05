<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        $activeTitle
    )
));

//if( $this->beginCache( 'add_page', array('duration'=>3600) ) ) :
?>

<?php
    $firm = CatalogContent::fetchBySlug("add_firm");
    $kurorts = CatalogContent::fetchBySlug("add_kurorts");
    $hotels = CatalogContent::fetchBySlug("add_hotels");
    $vacansy = CatalogContent::fetchBySlug("add_vacansy");
    $items = CatalogContent::fetchBySlug("add_items");
    $otherInfo = CatalogContent::fetchBySlug("other-info");
?>

<div id="InnerText" class="innerPage">
    <h1><?= Yii::t("add", "Бесплатное добавление туристической информации на сайт"); ?></h1>
    <div id="dopMenu">
        <a href="#" id="travel-agency" class="<?= $activeTab == "travel-agency" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("add", "Добавление фирмы"); ?><br/>&nbsp;</a>
        <a href="#" id="curorts" class="<?= $activeTab == "curorts" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("add", "Добавление курортов/зон отдыха"); ?></a>
        <a href="#" id="hotels" class="<?= $activeTab == "hotels" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("add", "Добавление гостиницы"); ?><br/>&nbsp</a>
        <a href="#" id="vacancy-resume" class="<?= $activeTab == "vacancy-resume" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("add", "Добавление вакансий/резюме"); ?><br/>&nbsp</a>
        <a href="#" id="ads-items" class=<?= $activeTab == "ads-items" ? "activeDM " : "" ?>"dopMenuPages"><?= Yii::t("add", "Добавление частных объявлений"); ?></a>
        <a href="#" id="other-info" class=<?= $activeTab == "other-info" ? "activeDM " : "" ?>"dopMenuPages"><?= Yii::t("add", "Добавление прочей информация"); ?></a>
    </div>
    <br/>
    <div id="travel-agency_page" class="pageTab<?= $activeTab == "travel-agency" ? " activePage " : " displayNone" ?>">
        <h2><?= Yii::t("add", "Добавление фирмы"); ?></h2>
        <?= $firm->description; ?>
        <br/>
        <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/firms/description" ) ?>" class="addButton" title="<?= Yii::t("add", "добавить бесплатно туристическое агенство"); ?>"> <?= Yii::t("add", "добавить туристическое агенство БЕСПЛАТНО"); ?></a></div>
    </div>
    <div id="curorts_page" class="pageTab<?= $activeTab == "curorts" ? " activePage " : " displayNone" ?>">
        <h2>><?= Yii::t("add", "Добавление курортов/зон отдыха"); ?></h2>
        <?= $kurorts->description; ?>
        <br/>
        <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/resort/description" ) ?>" class="addButton" title="<?= Yii::t("add", "Добавить зону отдыха/курорт бесплатно"); ?>"> <?= Yii::t("add", "добавить зону отдыха/курорт БЕСПЛАТНО"); ?></a></div>
    </div>
    <div id="hotels_page" class="pageTab<?= $activeTab == "hotels" ? " activePage " : " displayNone" ?>">
        <h2>><?= Yii::t("add", "Добавление гостиницы"); ?></h2>
        <?= $hotels->description; ?>
        <br/>
        <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/hotels/description" ) ?>" class="addButton" title="<?= Yii::t("add", "Добавить гостиницу бесплатно"); ?>"> <?= Yii::t("add", "Добавить гостиницу БЕСПЛАТНО"); ?></a></div>
    </div>
    <div id="vacancy-resume_page" class="pageTab<?= $activeTab == "vacancy-resume" ? " activePage " : " displayNone" ?>">
        <h2><?= Yii::t("add", "Добавление вакансий/резюме"); ?></h2>
        <?= $vacansy->description; ?>
        <br/>
        <div class="textAlignCenter">
            <a href="<?= SiteHelper::createUrl( "/user/work/description" ) ?>" class="addButton" title="<?= Yii::t("add", "Добавить вакансию бесплатно"); ?>"> <?= Yii::t("add", "Добавить Вакансию БЕСПЛАТНО"); ?></a>&nbsp;
            <a href="<?= SiteHelper::createUrl( "/user/resume/description" ) ?>" class="addButton" title="<?= Yii::t("add", "Добавить резюме бесплатно"); ?>"> <?= Yii::t("add", "Добавить резюме БЕСПЛАТНО"); ?></a>
        </div>
    </div>
    <div id="ads-items_page" class="pageTab<?= $activeTab == "ads-items" ? " activePage " : " displayNone" ?>">
        <h2><?= Yii::t("add", "Добавление частных объявлений"); ?></h2>
        <?= $items->description; ?>
        <br/>
        <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/items/description" ) ?>" class="addButton" title="<?= Yii::t("add", "Добавить частное объявление БЕСПЛАТНО"); ?>"><?= Yii::t("add", "Добавить частное объявление БЕСПЛАТНО"); ?></a></div>
    </div>
    <div id="other-info_page" class="pageTab<?= $activeTab == "other-info" ? " activePage " : " displayNone" ?>">
        <h2><?= Yii::t("add", "Прочая информация"); ?></h2>
        <?= $otherInfo->description; ?>
        <br/>
        <?= Yii::t("add", "Email для запроса:"); ?> <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>
    </div>
    <div class="greeBorder">
        <p>
            <b><?= Yii::t("add", "Внимание!!!"); ?></b><br/>
            <?= Yii::t("add", "При переходе Вам необходимо будет авторизоватся, либо зарегестрироваться если у вас нет логина. После этого Вы сможете вносить информацию."); ?><br/>
        </p>
        <p>
            <b><?= Yii::t("add", "Возникли вопросы?"); ?></b><br/>
            <?= Yii::t("add", "Пишите нам на Email <a href='mailto:support@world-travel.uz'>support@world-travel.uz</a>, мы будем рады на них ответить."); ?>
        </p>
        <p>
            <b><?= Yii::t("add", "Ваша информация, фирма, отель или прочая информация уже размещене на сайте?"); ?> </b><br/>
            <?= Yii::t("add", "Если Вы хотите изменить её или удалить, Вам необходимо"); ?> <a href="<?= SiteHelper::checkedSlugName("/add/confirm") ?>" title="<?= Yii::t("add", "подтвердить информацию"); ?>"><?= Yii::t("add", "подтвердить информацию"); ?></a>.
        </p>
    </div>
</div>
