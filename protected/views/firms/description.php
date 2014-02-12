<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "туристические фирмы"=>SiteHelper::createUrl("firms/"),
        $item->country_id->name_2=>SiteHelper::createUrl("firms/index", array( "country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ) )),
        $item->name
    )
));
$listComments = CatalogFirmsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setOrderBy("id DESC")->setLimit(50)->setCache(0));
$listService = CatalogFirmsService::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
$listTours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
$listItems = CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
?>

<div id="InnerText" class="innerPage">
    <?php
    SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
    ?>
    <h1>туристическая компания - <?= $item->name ?></h1>
    <?= FirmsHelper::getBannerByCategory( "1", $item->id  ) ?>
    <div id="dopMenu">
        <a href="#" id="description" class="<?= $activeTab == "description" ? "activeDM " : "" ?>dopMenuPages">Описание</a>
        <a href="#" id="gallery2" class="dopMenuPages">Галлерея (<?= sizeof( $listGallery ) ?>)</a>
        <a href="#" id="tours" class="dopMenuPages">Туры компаниии (<?= sizeof( $listTours ) ?>)</a>
        <a href="#" id="items" class="dopMenuPages">Акции и скидки (<?= sizeof( $listItems ) ?>)</a>
        <a href="#" id="service" class="dopMenuPages">Дополнительные услуги (<?= sizeof( $listService ) ?>)</a>
        <a href="#" id="pcomments" class="<?= $activeTab == "pcomments" ? "activeDM " : "" ?>dopMenuPages">Коментарии и отзывы (<?= sizeof( $listComments ) ?>)</a>
    </div>
    <br/>
    <div id="pcomments_page" class="pageTab<?= $activeTab == "pcomments" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "pcomemts_page", array("item"=>$item, "commentModel"=>$commentModel, "items"=>$listComments) ) ?>
    </div>
    <div id="service_page" class="pageTab displayNone">
        <?php $this->renderPartial( "service_page", array("item"=>$item, "items"=>$listService) ) ?>
    </div>
    <div id="items_page" class="pageTab displayNone">
        <?php $this->renderPartial( "items_page", array("item"=>$item, "items"=>$listItems) ) ?>
    </div>
    <div id="tours_page" class="pageTab displayNone">
        <?php $this->renderPartial( "tours_page", array("item"=>$item, "items"=>$listTours) ) ?>
    </div>
    <div id="gallery2_page" class="pageTab displayNone">
        <div id="gallery">
            <h2>Галлерея</h2>
            <div class="listGallery">
                <?php foreach( $listGallery as $gall ) : ?>
                    <div class="LGItem">
                        <div>
                            <a href="<?= $gall->image ?>" data-lightbox="roadtrip"><img src="<?= ImageHelper::getImage( $gall->image, 2 ) ?>" /></a>
                        </div>
                        <?= $gall->name ?><br/>
                    </div>
                <?php endforeach; ?>
                <?php if( sizeof( $listGallery ) == 0 ) : ?><div class="textAlignCenter">Список пуст</div><?php endif; ?>
            </div>
        </div>
    </div>
    <div id="description_page" class="pageTab<?= $activeTab == "description" ? " activePage " : " displayNone" ?>">
        <div id="ITText">
            <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="Туристическия странна <?= $item->name ?>" /></div><?php endif; ?>
            <div class="LParams">
                <br/>
                страна: <a href="<?= SiteHelper::createUrl("country/", array("id"=>$item->country_id->id)) ?>" title="туристическая страна <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
                туров: <b><?= $tourCount ?></b>
                <br/><br/>
                <a class="OrderRequest LPLink" href="#" title="связаться">связаться забронировать</a><br/>
            </div>
            <table class="tableForm">
                <?=
                CCmodelHelper::infoForm( $item )
                ?>
            </table>
            <div id="orderInfo" class="displayNone">
                <b>Туристическая фирма - <?= $item->name ?></b><br/>
                <p>Для бронирования или уточнения информации по турам необходимо связаться с менеджером компании <?= $item->name ?>.</p>
                <p>
                    <b>контакты компании:</b><br/>
                    <?php if( $item->tel ) : ?>Телефон: <?= $item->tel ?><br/><?php endif; ?>
                    <?php if( $item->fax ) : ?>Факс: <?= $item->fax ?><br/><?php endif; ?>
                    <?php if( $item->email ) : ?>E-mail: <span><a href="#" onclick="$( this.parentNode ).load( '<?= SiteHelper::createUrl( "/site/getInfo", array( "catalog"=>"catalogFirms", "id"=>$item->id, "field"=>"email" ) ) ?>' ); return false;">[ Показать Email ]</a></span><br/><?php endif; ?>
                    <?php if( $item->www ) : ?>Сайт: <a href="<?= $item->www ?>" target="_blank"><?= $item->www ?></a><br/><?php endif; ?>
                    <?php if( $item->address ) : ?><b>Адресс:</b> <?= $item->address ?><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a>
                </div>
                </p>
            </div>
        </div>
        <?= $item->description ?>
    </div>
    <?= FirmsHelper::getBannerByCategory( "2", $item->id  ) ?>

    <?php if( sizeof($otherFirms)>0 ) : ?>
        <h2>Смотрите также</h2>
        <div class="ITBlock ITBFirms">
            <?php foreach( $otherFirms as $tour ) : ?>
                <?php $this->widget("firmWidget", array( "item"=>$tour )) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>