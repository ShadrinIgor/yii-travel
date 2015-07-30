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
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#FDescription" data-toggle="tab"><?= Yii::t("page", "Описание"); ?></a></li>
        <?php if( sizeof($listGallery) >0 ) : ?><li><a href="#FGallery" data-toggle="tab"><?= Yii::t("page", "Галерея"); ?> (<?= sizeof( $listGallery ) ?>)</a></li><?php endif; ?>
        <?php if( sizeof($listTours) >0 ) : ?><li><a href="#FTours" data-toggle="tab"><?= Yii::t("travelAgency", "Туры компании"); ?> (<?= sizeof( $listTours ) ?>)</a></li><?php endif; ?>
        <?php if( sizeof($listItems) >0 ) : ?><li><a href="#FItems" data-toggle="tab"><?= Yii::t("travelAgency", "Акции и скидки"); ?> (<?= sizeof( $listItems ) ?>)</a></li><?php endif; ?>
        <?php if( sizeof($listService) >0 ) : ?><li><a href="#FService" data-toggle="tab"><?= Yii::t("travelAgency", "Дополнительные услуги"); ?> (<?= sizeof( $listService ) ?>)</a></li><?php endif; ?>
        <li><a href="#FComment" data-toggle="tab"><?= Yii::t("travelAgency", "Комментарии и отзывы"); ?> (<?= sizeof( $listComments ) ?>)</a></li>
    </ul>
    <br/>
    <div class="tab-content">
        <div id="FComment" class="tab-pane<?= $activeTab == "pcomments" ? " active" : "" ?>">
            <?php $this->renderPartial( "pcomemts_page", array("item"=>$item, "commentModel"=>$commentModel, "items"=>$listComments) ) ?>
        </div>
        <div id="FService" class="tab-pane<?= $activeTab == "service" ? " active" : "" ?>">
            <?php $this->renderPartial( "service_page", array("item"=>$item, "items"=>$listService) ) ?>
        </div>
        <div id="FItems" class="tab-pane<?= $activeTab == "items" ? " active" : "" ?>">
            <?php $this->renderPartial( "items_page", array("item"=>$item, "items"=>$listItems) ) ?>
        </div>
        <div id="FTours" class="tab-pane<?= $activeTab == "tours" ? " active" : "" ?>">
            <?php $this->renderPartial( "tours_page", array( "categoryModel"=>$categoryModel ,"countryModel"=>$countryModel, "item"=>$item, "items"=>$listTours, "arrSearchFieldsTours"=>$arrSearchFieldsTours, "url"=>SiteHelper::createUrl("/travelAgency/description/")."/".$item->slug.".html" ) ) ?>
        </div>
        <div id="FGallery" class="tab-pane<?= $activeTab == "gallery" ? " active" : "" ?>">
            <div id="gallery">
                <h2><?= Yii::t("page", "Галерея"); ?></h2>
                <div class="listGallery">
                    <?php foreach( $listGallery as $gall ) : ?>
                        <div class="LGItem">
                            <div>
                                <a href="<?= $gall->image ?>" rel="lightbox[roadtrip]"><img src="<?= ImageHelper::getImage( $gall->image, 2 ) ?>" /></a>
                            </div>
                            <?= $gall->name ?><br/>
                        </div>
                    <?php endforeach; ?>
                    <?php if( sizeof( $listGallery ) == 0 ) : ?><div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div id="FDescription" class="tab-pane<?= $activeTab == "description" ? " active" : "" ?>">
            <div id="ITText">
                <div class="well">
                    <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="<?= Yii::t("page", "Туристическая страна"); ?> <?= $item->name ?>" /></div><?php endif; ?>
                    <?= $item->description ?>
                </div>
                <div class="well">
                    <h2>Контакты тур компании <?= $item->name ?></h2>
                    <p><?= Yii::t("page", "Для бронирования или уточнения информации по турам необходимо связаться с менеджером компании"); ?> <?= $item->name ?>.</p>
                    <p>
                        <b><?= Yii::t("page", "контакты компании"); ?>:</b><br/>
                        <?php if( $item->tel ) : ?><?= Yii::t("page", "Телефон"); ?>: <?= $item->tel ?><br/><?php endif; ?>
                        <?php if( $item->fax ) : ?><?= Yii::t("page", "Факс"); ?>: <?= $item->fax ?><br/><?php endif; ?>
                        <?php if( $item->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"CatalogFirms", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ <?= Yii::t("page", "Показать Email"); ?> ]</a></span><br/><?php endif; ?>
                        <?php if( $item->www ) : ?><?= Yii::t("page", "Сайт"); ?>: <a href="<?= $item->www ?>" target="_blank"><?= $item->www ?></a><br/><?php endif; ?>
                        <?php if( $item->address ) : ?><b><?= Yii::t("page", "адрес"); ?>:</b> <?= $item->address ?><?php endif; ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
    <?= FirmsHelper::getBannerByCategory( "2", $item->id  ) ?>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
</div>
<script type="text/javascript">
/*    $(function(){
        $(‘#myTab a’).click((e){
            e.preventDefault();
            $(this).tab(‘show’);
        })
    })*/
</script>