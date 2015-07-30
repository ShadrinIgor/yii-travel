<div id="findTour">
    <div id="FTHeader">
        <a href="#" id="FTForm" class="FTActive" title=""><?= Yii::t("page", "Найти тур"); ?></a>
        <font class="FTFormSepar"></font>
        <a href="#" id="FTHotels" title=""><?= Yii::t("page", "Найти отель"); ?></a>
    </div>
    <div id="FTFormTab" class="FTFActive FTFormTab">
        <form action="<?= SiteHelper::createUrl("/tours") ?>" method="post">
            <p>
                <?= Yii::t("page", "От куда"); ?>: <select name="countryFrom"><option value=""><?= Yii::t("page", "Узбекистан"); ?></option></select>
            </p>
            <p>
                <?= Yii::t("page", "Куда"); ?>: <select name="CatalogTours[country_id]">
                    <option value=""> - <?= Yii::t("page", "выберите страну тура"); ?> - </option>
                    <?php foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("name")->setLimit(-1)) as $country ) : ?>
                        <option value="<?= $country->id ?>"><?= $country->name ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <?= Yii::t("page", "Категория"); ?>: <select name="CatalogTours[category_id]">
                    <option value=""> - <?= Yii::t("page", "выберите категорию"); ?> - </option>
                    <?php foreach( CatalogToursCategory::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("owner=0")->setOrderBy("name")->setLimit(-1)) as $category ) : ?>
                        <optgroup label="<?= $category->name ?>">
                            <?php foreach( CatalogToursCategory::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("owner=:owner")->setParams(array(":owner"=>$category->id))->setOrderBy("name")->setLimit(-1)) as $category2 ) : ?>
                                <option value="<?= $category2->id ?>"><?= $category2->name ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </p>
            <div class="FTBottom" id="FTBF">
                <div class="floatRight">
                    <input type="submit" name="find" value="<?= Yii::t("page", "Подобрать"); ?>" />
                </div>
                <?= Yii::t("page", "Форма подбора тура по стране и категории"); ?>
            </div>
        </form>
    </div>
    <div id="FTHotelsTab" class="FTFormTab">
        <form action="<?= SiteHelper::createUrl("/hotels") ?>" method="post">
            <p>
                <?= Yii::t("page", "Страна"); ?>:
                <select name="CatalogHotels[country_id]" class="field_country_id">
                    <option value=""> - <?= Yii::t("page", "выберите страну"); ?> - </option>
                    <?php foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("name")->setLimit(-1)) as $country ) : ?>
                        <option value="<?= $country->id ?>"><?= $country->name ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <?= Yii::t("page", "Город"); ?>: <select name="CatalogHotels[city_id]" class="field_city_id"><option value=""><?= Yii::t("page", "выберите страну"); ?></option></select>
            </p>
            <p>
                <?= Yii::t("page", "Звезд"); ?>: <select name="CatalogHotels[level]">
                    <option value=""> - <?= Yii::t("page", "уровень отеля"); ?> - </option>
                    <option value="5"> 5 </option>
                    <option value="4"> 4 </option>
                    <option value="3"> 3 </option>
                    <option value="2"> 2 </option>
                    <option value="1"> 1 </option>
                </select>
            </p>
            <div class="FTBottom" id="FTBF">
                <div class="floatRight">
                    <input type="submit" name="find" value="<?= Yii::t("page", "Подобрать"); ?>" />
                </div>
                <?= Yii::t("page", "Форма подбора отеля по стране и уровню"); ?>
            </div>
        </form>
    </div>
</div>