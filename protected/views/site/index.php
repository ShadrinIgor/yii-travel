<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

// if( $this->beginCache( "firstPage", array('duration'=>3600) ) ) :
?>
    <div id="Buttons">
        <?php $this->widget("topButtonWidget", array( "type"=>"add_first" )) ?>
        <?php $this->widget("topButtonWidget", array( "type"=>"confirm_first" )) ?>
    </div>

    <div class="hr">&nbsp;</div>

    <div id="FCountryList">
        <?php
            $countryLIst = CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "baner>''" )->setLimit(4) );
            foreach( $countryLIst as $item ) :
        ?>
        <div class="FCountry" style="background:url( <?= $item->baner ?> ) -15px -7px no-repeat;">
            <div class="FCItems">
                <ul>
                    <?php foreach( CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array(":country"=>$item->id) )->setLimit(4) ) as $item2  ) : ?>
                    <li>
                        <a href="<?= SiteHelper::createUrl( "/tours/description" )."/".$item2->slug ?>.html" title="<?= $item2->name ?>"><?= $item2->name ?><b><?= $item2->price>0 ? " - ".$item2->price."$" : "" ?></b></a>
                        <div class="display_none fc_popup">
                            <?php if( $item2->image ) : ?><img src="<?= ImageHelper::getImage( $item2->image, 2 ) ?>" alt="<?= $item2->name ?>" /><?php endif; ?>
                            <?php if( $item2->price>0 ) : ?>Стоимость: <b><?= $item2->price ?>$</b><br/><?php endif; ?>
                            <?= SiteHelper::getSubTextOnWorld( $item2->description, 400 ) ?>
                            <div class="textAlignRight">
                                <a class="cMore" href="<?= SiteHelper::createUrl( "/tours/description" )."/".$item2->slug ?>.html" title="<?= $item2->name ?>">читать подробнее</a>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <p><a href="<?= SiteHelper::createUrl( "/tours/country" )."/".$item->slug ?>.html">смотреть все туры <?= $item->name_2 ?></a></p>
                <p><a href="<?= SiteHelper::createUrl( "/hotels/country" )."/".$item->slug ?>.html">отели <?= $item->name_2 ?></a></p>
                <p><a href="<?= SiteHelper::createUrl( "/touristInfo/country" )."/".$item->slug ?>.html">туристическая информаци <?= $item->name_2 ?></a></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="fc_other">
        <div id="fc_other_01">
            <div id="fc_other_02">
                <h3>Все туристические страны:</h3>
                <?php  if( $this->beginCache( "firstPage", array('duration'=>3600) ) ) : ?>
                    <ul>
                        <?php foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1) ) as $item ) :
                            $tour = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country_id" )->setParams( array( "country_id"=>$item->id ) ) );
                            $hotels = CatalogHotels::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country_id" )->setParams( array( "country_id"=>$item->id ) ) );
                            $info = CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country_id" )->setParams( array( "country_id"=>$item->id ) ) );
                            ?>
                            <li>
                                <a href="<?= SiteHelper::createUrl( "/tours/country" )."/".$item->slug ?>.html" title="Туры <?= $item->name_2 ?>" onmouseover="displayOrNone('fcp_lt_<?= $item->id ?>')" onmouseout="displayOrNone('fcp_lt_<?= $item->id ?>')"><img src="<?= $item->flag ?>" alt="<?= $item->name ?>" /><br/><?= $item->name ?></a>
                                <div class="display_none fc_popup fc_popup_lt" id="fcp_lt_<?= $item->id ?>" >
                                    <?php if( $tour>0 ) : ?>Туров: <b><?= $tour ?></b><br/><?php endif; ?>
                                    <?php if( $hotels>0 ) : ?>Отелей: <b><?= $hotels ?></b><br/><?php endif; ?>
                                    <?php if( $info>0 ) : ?>Статей: <b><?= $info ?></b><br/><?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php $this->endCache(); endif;?>
            </div>
        </div>
    </div>

    <div id="storiesBlok">
        <div style="float:right"><a href="stories/" title="туристические рассказы"><u>все рассказы</u>...</a></div>
        <h3>Расказы туристов</h3>
        <div id="storiesBlokItems">
            <ul>
                <?php foreach( CatalogContent::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("id DESC")->setLimit(4) ) as $item ) : ?>
                    <li>
                        <div class="centrItem story">
                            <p class="cTitle"><a title="<?= $item->name ?>" href="stories/4351/"><?= $item->name ?></a> <?php if( $item->date ) : ?><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><?php endif; ?></p>
                            <?php if( $item->image ) : ?><a href="stories/4351/" title="<?= $item->name ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $item->name ?>" title="<?= $item->name ?>" /></a><?php endif; ?>
                            <div class="textBlock">
                                <p><?= SiteHelper::getSubTextOnWorld( $item->description, 200 ) ?></p>
                            </div>
                            <a class="cMore" title="Подробнее <?= $item->name ?>" href="stories/4351/">подробнее...</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

