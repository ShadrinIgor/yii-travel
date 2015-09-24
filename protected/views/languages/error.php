<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle= $title." - ". Yii::app()->name;

?>

<div class="pageError">
    <div>
        <h2><?= $title; ?></h2>
        <div class="panel panel-success">
            <div class="panel-heading textAlignCenter">
                <?= $description ?>
            </div>
        </div>
    </div>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.3&appId=1434241406871609";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div id="MCenter">
    <div id="MCFind">
        <h2>Найди лучший тур, для себя</h2>
        <form action="<?= SiteHelper::createUrl("/tours") ?>" method="post">
            <div class="MFRow">
                <div class="FBlock">откуда едем:<br/><input type="text" name="find[from]" value="Узбекистан" readonly /></div>
                <div class="FBlock">
                    куда едем:<br/>
                    <select name="CatalogTours[country_id]">
                        <option value="">выберите страну</option>
                        <?php foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("EXISTS(SELECT id FROM catalog_tours WHERE country_id=catalog_country_as.id )")->setLimit(-1)->setOrderBy("name") ) as $cItem ) : ?>
                            <option value="<?= $cItem->id ?>"><?= $cItem->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="FBlock">
                    категории отдыха:<br/>
                    <select name="CatalogTours[category_id]">
                        <option value="">выберите категорию</option>
                        <?php foreach( CatalogToursCategory::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("EXISTS(SELECT id FROM catalog_tours WHERE category_id=catalog_tours_category_as.id ) AND owner>0")->setLimit(-1)->setOrderBy("name") ) as $cItem ) : ?>
                            <option value="<?= $cItem->id ?>"><?= $cItem->name ?></option>
                        <?php endforeach; ?>
                        <option value="">Еще категория</option>
                        <option value="">Третья категория</option>
                    </select>
                </div>
            </div>
            <div class="MFRow">
                <div class="FBlock">цена от (USD):<br/><input type="text" name="CatalogTours[price]" value="" /></div>
                <div class="FBlock">цена до (USD):<br/><input type="text" name="CatalogTours[price_2]" value="" /></div>
                <div class="FBlock FBSubmit"><input type="submit" name="send_find" value="НАЙТИ" /></div>
            </div>
        </form>
    </div>
    <div class="ListTours">
        <h2>Популярные туристические страны</h2>
        <?php foreach( CatalogCountry::sql("SELECT c.id as id, c.name as name, c.title as title, c.description as description, c.banner2 as banner2, count(t.id) as tour_count, c.slug as slug, c.name_2 as name2 FROM `catalog_tours` t, catalog_country c WHERE c.id=t.country_id GROUP BY t.country_id ORDER BY count(t.id)  DESC LIMIT 10") as $line ) :
            $minTour = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:id AND price>0")->setParams( [":id"=>$line["id"] ] )->setOrderBy("price")->setLimit(1) );
            $currency = $minTour[0]->currency_id->id >0 ? $minTour[0]->currency_id->title : "$";
            ?>
            <div class="LTItem">
                <div class="LTImag"><a href="<?= SiteHelper::createUrl("/countryPage", array("country"=>$line["slug"] ) ) ?>" title="<?= $line["title"] ?>"><img src="<?= $line["banner2"] ?>" alt="<?= $line["title"] ?>" /></a></div>
                <div class="LTPrice">
                    <span><a href="<?= SiteHelper::createUrl("/countryPage", array("country"=>$line["slug"] ) ) ?>" title="Туристическая страна <?= $line["title"] ?>"><?= $line["name"] ?> от <b><?= $minTour[0]->price ?><?= $currency ?></b></a></span>
                    <div class="displayNone">
                        <div class="LTText"><a href="<?= SiteHelper::createUrl("/countryPage", array("country"=>$line["slug"] ) ) ?>" title="Туристическая страна - <?= $line["name"] ?>"><?= SiteHelper::getSubTextOnWorld( $line["description"], 600 ) ?></a></div>
                        <div class="textAlignRight"><a href="<?= SiteHelper::createUrl("/countryPage", array("country"=>$line["slug"] ) ) ?>" title="Смотреть туры <?= $line["name2"] ?>">смотреть все <?= $line["tour_count"] ?> тура(ов) >>></a></div>
                    </div>
                </div>
                <div class="overflowHidden">
                    <?= $line["tour_count"] ?> предложений
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="ListTours2">
        <h2>Лучшие туры</h2>
        <?php foreach( CatalogTours::sql( "SELECT t.*, g.image as image2 FROM catalog_tours t, cat_gallery g WHERE g.catalog='catalog_tours' AND g.item_id = t.id GROUP BY country_id ORDER BY t.rating DESC LIMIT 10" ) as $item ): ?>
            <div class="LTItem2">
                <div class="LTHover2"><a href="<?= SiteHelper::createUrl("/tours/description" )."/".$item["slug"].".html" ?>" title="<?= $item["name"] ?>"><?= $item["name"] ?></a></div>
                <div class="LTImag2"><a href="<?= SiteHelper::createUrl("/tours/description" )."/".$item["slug"].".html" ?>" title="<?= $item["name"] ?>"><img src="<?= ImageHelper::getImage( $item["image2"], 2 ) ?>" alt="<?= $item["name"] ?>" /></a></div>
                <?php if( $item["price"] > 0 ) : ?><div class="LTPrice2">от <b><?= $item["price"] ?>$</b>&nbsp;</div><?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <br/>
</div>

<div class="row textAlignCenter">
    <div class="fb-page" data-href="https://www.facebook.com/pages/World-Traveluz/280386002122600" data-width="2000px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/World-Traveluz/280386002122600"><a href="https://www.facebook.com/pages/World-Traveluz/280386002122600">World-Travel.uz</a></blockquote></div></div>
</div>
<br/><br/>