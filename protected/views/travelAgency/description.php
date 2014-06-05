<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("travelAgency", "Туристические агентства").$item->country_id->name_2=>SiteHelper::createUrl("/travelAgency"),
        $item->name
    )
));
$listComments = CatalogFirmsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setOrderBy("id DESC")->setLimit(-1)->setCache(0));
$listService = CatalogFirmsService::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(-1)->setCache(0));
$toursCondition = "firm_id=:firm_id AND active=1";
$tourParams = array( ":firm_id"=>$item->id );
$country = Yii::app()->request->getParam( "country", "" );
if( !empty( $country ) )$countryModel = CatalogCountry::fetchBySlug( $country );
                   else $countryModel = new CatalogCountry();

$category = Yii::app()->request->getParam( "category", "" );
if( !empty( $category ) )$categoryModel = CatalogToursCategory::fetchBySlug( $category );
                    else $categoryModel = new CatalogToursCategory();

if( $countryModel->id > 0 )$toursCondition .= " AND country_id='".$countryModel->id."'";
if( $categoryModel->id >0 )$toursCondition .= " AND category_id='".$categoryModel->id."'";

$listTours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $toursCondition )->setParams( $tourParams )->setOrderBy( "pos DESC" )->setLimit(-1)->setCache(0));
$listItems = CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(-1)->setCache(0));

?>
<div id="InnerText" class="innerPage">
    <br/>
    <?php
    SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <h1><?= $item->name ?> <font>- <?= Yii::t("travelAgency", "туристическое агенство"); ?> <?= $item->country_id->name_2 ?> <?= $item->city_id->name ?></font></h1>
    <?= FirmsHelper::getBannerByCategory( "1", $item->id  ) ?>
    <div id="dopMenu">
        <a href="#" id="description" class="<?= $activeTab == "description" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("page", "Описание"); ?></a>
        <?php if( sizeof($listGallery) >0 ) : ?><a href="#" id="gallery2" class="<?= $activeTab == "gallery" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("page", "Галерея"); ?> (<?= sizeof( $listGallery ) ?>)</a><?php endif; ?>
        <?php if( sizeof($listTours) >0 ) : ?><a href="#" id="tours" class="<?= $activeTab == "tours" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("travelAgency", "Туры компаниии"); ?> (<?= sizeof( $listTours ) ?>)</a><?php endif; ?>
        <?php if( sizeof($listItems) >0 ) : ?><a href="#" id="items" class="<?= $activeTab == "description" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("travelAgency", "Акции и скидки"); ?> (<?= sizeof( $listItems ) ?>)</a><?php endif; ?>
        <?php if( sizeof($listService) >0 ) : ?><a href="#" id="service" class="<?= $activeTab == "service" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("travelAgency", "Дополнительные услуги"); ?> (<?= sizeof( $listService ) ?>)</a><?php endif; ?>
        <a href="#" id="pcomments" class="<?= $activeTab == "pcomments" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("travelAgency", "Комментарии и отзывы"); ?> (<?= sizeof( $listComments ) ?>)</a>
    </div>
    <br/>
    <div id="pcomments_page" class="pageTab<?= $activeTab == "pcomments" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "pcomemts_page", array("item"=>$item, "commentModel"=>$commentModel, "items"=>$listComments) ) ?>
    </div>
    <div id="service_page" class="pageTab<?= $activeTab == "service" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "service_page", array("item"=>$item, "items"=>$listService) ) ?>
    </div>
    <div id="items_page" class="pageTab<?= $activeTab == "items" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "items_page", array("item"=>$item, "items"=>$listItems) ) ?>
    </div>
    <div id="tours_page" class="pageTab<?= $activeTab == "tours" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "tours_page", array( "categoryModel"=>$categoryModel ,"countryModel"=>$countryModel, "item"=>$item, "items"=>$listTours, "arrSearchFieldsTours"=>$arrSearchFieldsTours, "url"=>SiteHelper::createUrl("/travelAgency/description/")."/".$item->slug.".html" ) ) ?>
    </div>
    <div id="gallery2_page" class="pageTab<?= $activeTab == "gallery" ? " activePage " : " displayNone" ?>">
        <div id="gallery">
            <h2><?= Yii::t("page", "Галерея"); ?></h2>
            <div class="listGallery">
                <?php foreach( $listGallery as $gall ) : ?>
                    <div class="LGItem">
                        <div>
                            <a href="<?= $gall->image ?>" data-lightbox="roadtrip"><img src="<?= ImageHelper::getImage( $gall->image, 2 ) ?>" /></a>
                        </div>
                        <?= $gall->name ?><br/>
                    </div>
                <?php endforeach; ?>
                <?php if( sizeof( $listGallery ) == 0 ) : ?><div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div><?php endif; ?>
            </div>
        </div>
    </div>
    <div id="description_page" class="pageTab<?= $activeTab == "description" ? " activePage " : " displayNone" ?>">
        <div id="ITText">
            <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="<?= Yii::t("page", "Туристическая страна"); ?> <?= $item->name ?>" /></div><?php endif; ?>
            <div class="LParams">
                <br/>
                <?= Yii::t("page", "страна"); ?>: <a href="<?= SiteHelper::createUrl("country/", array("id"=>$item->country_id->id)) ?>" title="<?= Yii::t("page", "туристическая страна"); ?> <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
                <?= Yii::t("page", "туров"); ?>: <b><?= sizeof( $listTours ) ?></b>
                <br/><br/>
                <a class="OrderRequest LPLink" href="#" title="<?= Yii::t("page", "связаться"); ?>"><?= Yii::t("page", "связаться забронировать"); ?></a><br/>
            </div>
            <table class="tableForm">
                <?=
                CCModelHelper::infoForm( $item )
                ?>
            </table>

            <div id="orderInfo" class="displayNone">
                <b><?= Yii::t("page", "Туристическое агенство"); ?> - <?= $item->name ?></b><br/>
                <p><?= Yii::t("page", "Для бронирования или уточнения информации по турам необходимо связаться с менеджером компании"); ?> <?= $item->name ?>.</p>
                <p>
                    <b><?= Yii::t("page", "контакты компании"); ?>:</b><br/>
                    <?php if( $item->tel ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->tel ?><br/><?php endif; ?>
                    <?php if( $item->fax ) : ?><?= Yii::t("page", "Факс"); ?>: <?= $item->fax ?><br/><?php endif; ?>
                    <?php if( $item->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"CatalogFirms", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                    <?php if( $item->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a href="<?= $item->www ?>" target="_blank"><?= $item->www ?></a><br/><?php endif; ?>
                    <?php if( $item->address ) : ?><b><?= Yii::t("page", "адрес"); ?>:</b> <?= $item->address ?><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose"><?= Yii::t("page", "закрыть"); ?></a>
                </div>
                </p>
            </div>
        </div>
        <?= $item->description ?>
    </div>
    <?= FirmsHelper::getBannerByCategory( "2", $item->id  ) ?>
    <?php if( sizeof($otherFirms)>0 ) : ?>
        <h2><?= Yii::t("page", "Смотрите также"); ?></h2>
        <div class="ITBlock ITBFirms">
            <?php foreach( $otherFirms as $tour ) : ?>
                <?php $this->widget("firmWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
</div>