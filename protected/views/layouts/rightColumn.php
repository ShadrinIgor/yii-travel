<div id="Cleft">
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
    </div>

    <div id="share">
        <font>Поделитесь находкой:</font>
        <ul>
            <li id="CB_01"><a onclick="return new_window('http://vkontakte.ru/share.php?url=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_02"><a onclick="return new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_03"><a onclick="return new_window('http://www.facebook.com/sharer.php?u=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_04"><a onclick="return new_window('http://connect.mail.ru/share?url=http://www.world-travel.uz/',600,400);" href="#" class="mrc__plugin_like_button"></a></li>
            <li id="CB_05"><a onclick="return new_window('http://twitter.com/share?url=http://www.world-travel.uz/',600,400);" href="#"></a></li>
            <li id="CB_06"><a href="#" onclick="return new_window('http://www.livejournal.com/update.bml?event=http://www.world-travel.uz/',800,600);"></a></li>
        </ul>
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

    <?php $this->widget("curortsWidget"); ?>

    <div id="keywords">
        <hr/>
        <a class="key05" href="curorts/10/" title="Зона отдыха «Мраморная речка»">Зона отдыха «Мраморная речка»</a> <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <a class="key06" href="tours/394/" title="Ферганская долина. Продолжительность: 2 дня. ">Ферганская долина. Продолжительность: 2 дня. </a> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <a class="key04" href="info/510/" title="Читаем меню других стран. Что же выбрать?">Читаем меню других стран. Что же выбрать?</a> <a class="key04" href="tours/310/" title="Жемчужина Шелкового Пути ">Жемчужина Шелкового Пути </a> <a class="key05" href="tours/330/" title="Самарканд">Самарканд</a> <h4>виза в узбекистан</h4> <a class="key05" href="info/331/" title="САМЫЕ ПОПУЛЯРНЫЕ СПОСОБЫ ОБМАНА ТУРИСТОВ">САМЫЕ ПОПУЛЯРНЫЕ СПОСОБЫ ОБМАНА ТУРИСТОВ</a> <a class="key04" href="info/599/" title="Жестокие игры или экскурсии официальные и подпольные">Жестокие игры или экскурсии официальные и подпольные</a> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <a class="key01" href="hotels/301/" title="Amari Don Muang Airport">Amari Don Muang Airport</a> <h3>тур фирмы</h3> <b>отдых</b> <a class="key05" href="tours/73/" title="«ДОРОГАМИ КАРАВАНОВ ЧЕРЕЗ ГОРЫ И ПЕСКИ» (11 дней)">«ДОРОГАМИ КАРАВАНОВ ЧЕРЕЗ ГОРЫ И ПЕСКИ» (11 дней)</a> <b>туризм 2010</b> <a class="key01" href="hotels/209/" title="ADORA GOLF RESORT HOTEL">ADORA GOLF RESORT HOTEL</a> <font>путешествия по узбекистану</font> <a class="key01" href="curorts/30/" title="ДЕТСКИЙ ОЗДОРОВИТЕЛЬНЫЙ ЛАГЕРЬ "РАДУГА"">ДЕТСКИЙ ОЗДОРОВИТЕЛЬНЫЙ ЛАГЕРЬ "РАДУГА"</a> <a class="key05" href="hotels/163/" title="Akassia Swiss Resort">Akassia Swiss Resort</a> <a class="key02" href="info/136/" title="О культуре Узбекистана, Узбекский народ, прикладные Искусства">О культуре Узбекистана, Узбекский народ, прикладные Искусства</a> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>