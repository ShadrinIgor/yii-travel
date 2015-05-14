<h1><?= $item->title ?></h1>
<script type="text/javascript" src="<?= $Theme->baseUrl  ?>/js/jquery/jquery.jcarousellite.min.js"></script>
<div id="gallerySlide">
    <div class="GSB">
        <div class="prev"></div>
        <div class="next"></div>
    </div>
    <div class="GS">
        <ul>
            <?php foreach( $gallerySlide as $itemG ) : ?>
                <li><img src="<?= $itemG->image ?>" alt="<?= $itemG->name ?>" /></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

    <script type="text/javascript">
        $( document).ready( function()
        {
            $("#gallerySlide .GS").jCarouselLite({
                btnNext: "#gallerySlide .next",
                btnPrev: "#gallerySlide .prev",
                speed: 500,
                visible: 1,
                mouseWheel: true,
                auto: 4000
            });
        })
    </script>


<!--?php if( $this->beginCache( "country_page_".$item->id."_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?-->
<div id="InnerText">
    <div id="ITText" class="ITSmallText">
        <?= $item->description ?>
    </div>
    <div class="textAlignCenter">
        <a href="#" class="ITextHref" title="">Читать описание</a>
    </div>
</div>
<h2>Лучшие туры <?= $item->name_2 ?></h2>
<div id="catalogItems">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_tours", "template"=>"catalog_tours",
        "title"=>Yii::t("page", "Туры"),
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "sectionTextSlug" => array(
            "ru"=>"tekstovka-dlya-stranicy-tury",
            "ja"=>"8520-ツアーのtekstovkaページ",
            "ch"=>"8520-tekstovka页旅行团",
            "en"=>"8520-tekstovka-page-for-tours",
        ),
    ) ) ?>
</div>

<!--?php foreach( $tours as $tour ): ?>
    <div class="LTour2">
        <a href="" title=""><img src="<= ImageHelper::getImage( $tour->image, 2 ) ?>" alt="" /> </a>
        <div class="LTTitle">
            <b><= $tour->name ?></b><br/>
            <b><= $tour->name ?></b><br/>
            <div class="LTPrice3"><= $tour->price ?><= $tour->curency_id && $tour->curency_id->id >0 ? $tour->curency_id->name : "$" ?></div>
        </div>
    </div>
<php endforeach; ?-->

<table class="countryGalleryInfo">
    <tr>
        <td><h3>Галлерея</h3></td>
        <td><h3>Информация</h3></td>
    </tr>
    <tr>
        <td id="CGI01">
            <?php foreach( $gallery as $gal ): ?>
                <div class="CGItem"><a href="" title=""><img src="<?= ImageHelper::getImage( $gal->image, 2 ) ?>" alt="" /></a></div>
            <?php endforeach; ?>
        </td>
        <td id="CGI02">
            <?php $i=1;foreach( $info as $iiem ): ?>
                <div class="CIBlock<?= $i==sizeof( $info ) ? " CIBlockNoB" : "" ?>">
                    <a href="" title=""><?= $iiem->name  ?></a><br/>
                    <span><?= SiteHelper::getSubTextOnWorld( $iiem->description, 200 ) ?></span>
                </div>
            <?php $i++;endforeach; ?>
        </td>
    </tr>
</table>
<br/>
<?php if( sizeof( $monuments ) >0 ) : ?>
    <h3>Достопримечательности <?= $item->name_2 ?></h3>
    <?php foreach( $monuments as $mItem ) : ?>
        <a href="" title=""><img src="<?= ImageHelper::getImage( $mItem->image, 2 ) ?>" alt="" /> </a>
        <div class="LTTitle">
            <?= $tour->name ?>
        </div>
    <?php endforeach; ?>
    <br/>
<?php endif; ?>
<!--?php $this->endCache(); endif;?-->