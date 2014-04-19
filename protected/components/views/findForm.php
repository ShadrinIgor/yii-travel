<div id="findTour">
    <div id="FTHeader">
        <a href="#" id="FTForm" class="FTActive" title="">Найти тур</a>
        <font class="FTFormSepar"></font>
        <a href="#" id="FTHotels" title="">Найти отель</a>
    </div>
    <div id="FTFormTab" class="FTFActive FTFormTab">
        <form action="<?= SiteHelper::createUrl("/tours") ?>" method="post">
            <p>
                От куда: <select name="countryFrom"><option value="">Узбекистан</option></select>
            </p>
            <p>
                Куда: <select name="CatalogTours[country_id]">
                    <option value=""> - выберите страну тура - </option>
                    <?php foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("name")->setLimit(-1)) as $country ) : ?>
                        <option value="<?= $country->id ?>"><?= $country->name ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                Категория: <select name="CatalogTours[category_id]">
                    <option value=""> - выберите категорию - </option>
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
                    <input type="submit" name="find" value="Подобрать" />
                </div>
                Форма подбора тура по стране и категории
            </div>
        </form>
    </div>
    <div id="FTHotelsTab" class="FTFormTab">
        <form action="<?= SiteHelper::createUrl("/hotels") ?>" method="post">
            <p>
                Страна:
                <select name="CatalogHotels[country_id]" class="field_country_id">
                    <option value=""> - выберите страну - </option>
                    <?php foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("name")->setLimit(-1)) as $country ) : ?>
                        <option value="<?= $country->id ?>"><?= $country->name ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                Город: <select name="CatalogHotels[city_id]" class="field_city_id"><option value="">выберите страну</option></select>
            </p>
            <p>
                Звезд: <select name="CatalogHotels[level]">
                    <option value=""> - уровень отеля - </option>
                    <option value="5"> 5 </option>
                    <option value="4"> 4 </option>
                    <option value="3"> 3 </option>
                    <option value="2"> 2 </option>
                    <option value="1"> 1 </option>
                </select>
            </p>
            <div class="FTBottom" id="FTBF">
                <div class="floatRight">
                    <input type="submit" name="find" value="Подобрать" />
                </div>
                Форма подбора отелея по стране и уровню
            </div>
        </form>
    </div>
</div>