<div id="userCabinet">
    <ul>
        <li><a href="<?= SiteHelper::createUrl("/user/sales" ) ?>" title=""><?= Yii::t("page", "Мои АКЦИИ/СКИДКИ"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/firms" ) ?>" title=""><?= Yii::t("page", "Моя фирма"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/hotels" ) ?>" title=""><?= Yii::t("page", "Мои отели"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/resort" ) ?>" title=""><?= Yii::t("page", "Мои зоны отдыха"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/items" ) ?>" title=""><?= Yii::t("page", "Частные объявления"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/work" ) ?>" title=""><?= Yii::t("page", "Мои вакансии"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/resume" ) ?>" title=""><?= Yii::t("page", "Мои резюме"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/messages" ) ?>" title=""><?= Yii::t("page", "Сообщения"); ?></a></li>
        <li><a href="<?= SiteHelper::createUrl("/user/default/Profile" ) ?>" title=""><?= Yii::t("page", "Мой профиль"); ?></a></li>
        <!--li><a href="<?= SiteHelper::createUrl("/user/favorites" ) ?>" title="">Выбранное на заметку</a></li-->
        <li><a href="<?= SiteHelper::createUrl("/user/desktop" ) ?>" title=""><?= Yii::t("page", "Выбрать стиль сайта"); ?></a></li>
        <!-- a href="<?= SiteHelper::createUrl("/user/fprofile" ) ?>" title="">Финансов1ый профиль</a-->
    </ul>
    <div id="logOut">
        <a href="<?= SiteHelper::createUrl("/user/default/logout" ) ?>" title=""><?= Yii::t("page", "Выйти"); ?></a>
        <?= Yii::t("page", "нажмите чтобы<br/>выйти из кабинета"); ?>
    </div>
</div>