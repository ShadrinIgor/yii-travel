<div id="Cleft">
    <div class="LeftMenu">
        <h3>Категории</h3>
        <?php if( $this->beginCache( "info_category", array('duration'=>3600) ) ) : ?>
        <ul>
            <?php
            foreach( CatalogInfoCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1)->setConditions("owner=0") ) as $item_ ) :
            $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item_->id))->setLimit(-1) );
            ?>
            <li><a href="<?= SiteHelper::createUrl("info/", array("category_id"=>$item_->id)) ?>" title="<?= $item_->name ?> информация для туристов"><?= $item_->name ?> ( <?= $count ?> )</a>
                <ul>
                <?php
                foreach( CatalogInfoCategory::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setConditions("owner=:owner")->setParams(array(":owner"=>$item_->id))->setLimit(-1) ) as $item ) :
                    $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category")->setParams(array(":category"=>$item->id))->setLimit(-1) );
            ?>

                    <?php if( $count>0 ) : ?><li><a href="<?= SiteHelper::createUrl("info/", array("category_id"=>$item->id)) ?>" title="<?= $item->name ?> туры"><?= $item->name ?> ( <?= $count ?> )</a></li><?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php $this->endCache(); endif;?>
    </div>

    <div class="LeftMenu">
        <h3>Информация по странам</h3>
        <?php if( $this->beginCache( "info_country", array('duration'=>3600) ) ) : ?>
            <ul>
                <?php
                foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) :
                    $count = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country")->setParams(array(":country"=>$item->id))->setLimit(-1) );
                    if( $count > 0 ) :
                    ?>
                    <li><a href="<?= SiteHelper::createUrl("info/", array("country_id"=>$item->id)) ?>" title="тур. информация <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
                <?php
                    endif;
                endforeach; ?>
            </ul>
            <?php $this->endCache(); endif;?>
    </div>

    <?php $this->widget("curortsWidget"); ?>

    <div id="keywords">
        <hr/>
        <a class="key05" href="curorts/10/" title="Зона отдыха «Мраморная речка»">Зона отдыха «Мраморная речка»</a> <h4>турфирмы</h4> <font>Религия / Духовные центры</font> <b>туры</b> <b>путешествия</b> <font>путешествуй</font> <a class="key06" href="info/394/" title="Ферганская долина. Продолжительность: 2 дня. ">Ферганская долина. Продолжительность: 2 дня. </a> <h4>Эктримальный туризм</h4> <font>Животный мир</font> <h3>турция</h3> <a class="key04" href="info/510/" title="Читаем меню других стран. Что же выбрать?">Читаем меню других стран. Что же выбрать?</a> <a class="key04" href="info/310/" title="Жемчужина Шелкового Пути ">Жемчужина Шелкового Пути </a> <a class="key05" href="info/330/" title="Самарканд">Самарканд</a> <h4>виза в узбекистан</h4> <a class="key05" href="info/331/" title="САМЫЕ ПОПУЛЯРНЫЕ СПОСОБЫ ОБМАНА ТУРИСТОВ">САМЫЕ ПОПУЛЯРНЫЕ СПОСОБЫ ОБМАНА ТУРИСТОВ</a> <a class="key04" href="info/599/" title="Жестокие игры или экскурсии официальные и подпольные">Жестокие игры или экскурсии официальные и подпольные</a> <p>международный туризм</p> <b>отдых в горах</b> <h3>туристические агентства</h3> <a class="key01" href="hotels/301/" title="Amari Don Muang Airport">Amari Don Muang Airport</a> <h3>тур фирмы</h3> <b>отдых</b> <a class="key05" href="info/73/" title="«ДОРОГАМИ КАРАВАНОВ ЧЕРЕЗ ГОРЫ И ПЕСКИ» (11 дней)">«ДОРОГАМИ КАРАВАНОВ ЧЕРЕЗ ГОРЫ И ПЕСКИ» (11 дней)</a> <b>туризм 2010</b> <a class="key01" href="hotels/209/" title="ADORA GOLF RESORT HOTEL">ADORA GOLF RESORT HOTEL</a> <font>путешествия по узбекистану</font> <a class="key01" href="curorts/30/" title="ДЕТСКИЙ ОЗДОРОВИТЕЛЬНЫЙ ЛАГЕРЬ "РАДУГА"">ДЕТСКИЙ ОЗДОРОВИТЕЛЬНЫЙ ЛАГЕРЬ "РАДУГА"</a> <a class="key05" href="hotels/163/" title="Akassia Swiss Resort">Akassia Swiss Resort</a> <a class="key02" href="info/136/" title="О культуре Узбекистана, Узбекский народ, прикладные Искусства">О культуре Узбекистана, Узбекский народ, прикладные Искусства</a> <h4>детские ларегеря</h4> <p>отзывы</p>
        <hr/>
    </div>
</div>