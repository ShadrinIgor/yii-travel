<div id="Cleft">
    <?php $this->widget("authWidget"); ?>

    <div class="BIBlock LeftMenu">
        <?php if( $this->beginCache( "umor", array('duration'=>3600) ) ) : ?>
        <div class="BITItems">
            <?php
                $umor = CatalogUmor::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("rand()")->setLimit(3) );
                foreach( $umor as $item ) :
            ?>
                <p><?= $item->description ?></p>
            <?php endforeach; ?>
        </div>
        <?php $this->endCache();endif; ?>
        <a href="fany/" class="mLinks" title="весь юмор">весь юмор...</a>
        <br/>
    </div>

    <div id="share">
        <font>Поделитесь находкой:</font>
        <noindex>
        <ul>
            <li id="CB_01"><a onclick="return new_window('http://vkontakte.ru/share.php?url=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_02"><a onclick="return new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_03"><a onclick="return new_window('http://www.facebook.com/sharer.php?u=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_04"><a onclick="return new_window('http://connect.mail.ru/share?url=http://www.world-travel.uz/',600,400);" href="#" class="mrc__plugin_like_button"></a></li>
            <li id="CB_05"><a onclick="return new_window('http://twitter.com/share?url=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_06"><a href="#" onclick="return new_window('http://www.livejournal.com/update.bml?event=http://www.world-travel.uz/',800,600);"></a></li>
        </ul>
        </noindex>
        <!--
        <div><script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script><fb:like href="http://www.world-travel.uz/" layout="button_count" show_faces="false" width="200" font="lucida grande"></fb:like></div>
        -->
    </div>

    <?php if( $this->beginCache( "site_counts", array('duration'=>3600) ) ) : ?>
    <div id="RStatistic">
        <ul>
            <li><b>На сайте:</b></li>
            <li>туристических стран: <u><?= CatalogCountry::count() ?></u></li>
            <li>туров: <u><?= CatalogTours::count() ?></u></li>
            <li>курортов: <u><?= CatalogKurorts::count() ?></u></li>
            <li>гостиниц: <u><?= CatalogHotels::count() ?></u></li>
            <li>туристических фирм: <u><?= CatalogFirms::count() ?></u></li>
            <li>статей о туризме: <u><?= CatalogInfoCategory::count() ?></u></li>
            <!--    <li>частных объявлений: <u>45</u></li>
            -->
        </ul>
    </div>
    <?php $this->endCache();endif; ?>

    <div class="LeftMenu">
    </div>

    <?php $this->widget("infoWidget", array( "title"=>"Курорты", "class"=>"CatalogKurorts", "link"=>"/resorts" )); ?>

    <div id="keywords">
        <hr/>
        <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <h3>тур фирмы</h3> <b>отдых</b> <b>туризм 2010</b> <font>путешествия по узбекистану</font> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>