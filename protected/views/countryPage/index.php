<h1><?= $item->title ?></h1>
<script type="text/javascript" src="<?= $Theme->baseUrl  ?>/js/jquery/jquery.jcarousellite.min.js"></script>
<?php if( sizeof($gallerySlide)>0 ): ?>
    <div class="hidden-lg hidden-md row">
        <img src="<?= $gallerySlide[0]->image ?>" class="col-xs-12" alt="<?= $item->title.".".$gallerySlide[0]->name ?>" />
    </div>
<?php endif; ?>
<div id="gallerySlide" class="hidden-xs hidden-sm">
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

<?php if( $this->beginCache( "country_page_".$item->id."_".$page."_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
<div id="InnerText">
    <div id="ITText" class="ITSmallText">
        <?= $item->description ?>
    </div>
    <div class="textAlignCenter well center-block">
        <a href="#" class="ITextHref btn btn-primary btn-lg btn-block" title="Информация о стране">Информация о стране</a>
    </div>
</div>
<h2>Лучшие туры <?= $item->name_2 ?></h2>
<div id="catalogItems" class="CI2">
    <?php $this->widget( "pageWidget", array( "catalog"=>"catalog_tours", "template"=>"catalog_tours2",
        "title"=>$item->name.", лучшие туры и информация",
        "description" => $this->description,
        "keyWord" => $this->keyWord,
        "showFindForm" => false,
        "conditional" => "country_id=".$item->id,
        "order" => "rating DESC",
        "offset" => 10,
        "sectionTextSlug" => array(
            "ru"=>"tekstovka-dlya-stranicy-tury",
            "ja"=>"8520-ツアーのtekstovkaページ",
            "ch"=>"8520-tekstovka页旅行团",
            "en"=>"8520-tekstovka-page-for-tours",
        ),
    ) ) ?>
</div>
<div class="row countryGalleryInfo">
    <?php if( sizeof($gallery)>0 ) : ?>
        <div class="<?= ( sizeof($info)>0 ) ? "col-lg-6 col-md-6 col-sm-12 col-xs-12" : "col-xs-12" ?>" id="CGI01">
            <h3>Галлерея</h3>
            <div>
                <?php foreach( $gallery as $gal ): ?>
                    <div class="CGItem"><a href="<?= $gal->image ?>" data-toggle="lightbox" data-gallery="multiimages" title="<?= $item->title ?>"><img src="<?= ImageHelper::getImage( $gal->image, 2 ) ?>" alt="<?= $item->title ?>" /></a></div>
                <?php endforeach; ?>
                <script type="text/javascript">
                    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
                        event.preventDefault();
                        $(this).ekkoLightbox();
                    });
                </script>
            </div>
        </div>
    <?php endif; ?>
    <?php if( sizeof($info)>0 ) : ?>
        <div class="<?= ( sizeof($gallery)>0 ) ? "col-lg-6 col-md-6 col-sm-12 col-xs-12" : "col-xs-12" ?>" id="CGI02">
            <h3>Информация</h3>
            <?php $i=1;foreach( $info as $iiem ): ?>
                <div class="CIBlock<?= $i==sizeof( $info ) ? " CIBlockNoB" : "" ?>">
                    <ul><li><a href="<?= SiteHelper::createUrl("/touristInfo/description" )."/".$iiem->slug.".html" ?>" title="<?= $iiem->name  ?>"><?= $iiem->name  ?></a>.
                            <span><?= SiteHelper::getSubTextOnWorld( $iiem->description, 110 ) ?></span>
                        </li>
                    </ul>
                </div>
                <?php $i++;endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<br/>
<?php /*if( sizeof( $monuments ) >0 ) : ?>
    <div class="well textAlignCenter DP">
        <h3>Достопримечательности <?= $item->name_2 ?></h3>
        <?php foreach( $monuments as $mItem ) : ?>
            <div class="well textAlignCenter">
                <div class="DPImage"><a href="" title="<?= $mItem->name ?>"><img src="<?= ImageHelper::getImage( $mItem->image, 2 ) ?>" alt="" /> </a></div>
                <div class="LTTitle">
                    <a href="" title="<?= $mItem->name ?>"><?= $mItem->name ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <br/>
<?php endif;*/ ?>
<?php $this->endCache(); endif;?>