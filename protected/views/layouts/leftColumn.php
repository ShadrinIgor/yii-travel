<div id="findTour">
    <div id="FTHeader">
        <a href="#" id="FTForm" title="">Найти тур</a>
        <font></font>
        <a href="#" id="FTHotels" title="">Найти отель</a>
    </div>
    <div id="FTFormTab" class="FTFActive">
        <form action="" method="post">
            <p>
                От куда: <select name="countryFrom"><option value="">Узбекистан</option></select>
            </p>
            <p>
                Куда: <select name="countryTo"><option value="">Узбекистан</option></select>
            </p>
            <p>
                Категория: <select name="countryTo"><option value="">Развлекательные</option></select>
            </p>
            <div class="FTBottom" id="FTBF">
                <div class="floatRight">
                    <a href="">Подобрать</a>
                </div>
                Форма подбора тура по стране и категории
            </div>
        </form>
    </div>
    <div id="FTHotelsTab">
        <form action="" method="post">
            <p>
                Страна: <select name="countryFrom"><option value="">Узбекистан</option></select>
            </p>
            <p>
                Город: <select name="countryTo"><option value="">Узбекистан</option></select>
            </p>
            <p>
                Звезд: <select name="countryTo"><option value="">Развлекательные</option></select>
            </p>
            <div class="FTBottom" id="FTBF">
                <div class="floatRight">
                    <a href="">Подобрать</a>
                </div>
                Форма подбора тура по стране и категории
            </div>
        </form>
    </div>
</div>

<div id="LeftBG">
    <?php $this->widget("infoWidget", array( "class"=>"CatalogContent", "link"=>"/news", "category_id"=>2 )); ?>
    <?php $this->widget("infoWidget", array( "title"=>"Информация туристу", "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
</div>
