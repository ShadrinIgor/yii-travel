<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "туристические фирмы"=>SiteHelper::createUrl("firms/"),
        $item->country_id->name_2=>SiteHelper::createUrl("firms/index", array( "country_id"=>$item->country_id->id, "slug"=>SiteHelper::getSlug( $item->country_id ) )),
        $item->name
    )
));
?>

<?php if( $this->beginCache( "country_".$item->id, array('duration'=>3600) ) ) : ?>
    <div id="InnerText">
        <h1><?= $item->name ?></h1>
        <?php
        SiteHelper::renderDinamicPartial( "pageDescriptionTop" );
        ?>
        <div id="ITText">
            <?php if( $item->image ) : ?><div id="ITImage"><img src="<?= $item->image ?>" width="250" alt="Туристическия странна <?= $item->name ?>" /></div><?php endif; ?>
            <div class="LParams">
                <br/>
                страна: <a href="<?= SiteHelper::createUrl("country/", array("id"=>$item->country_id->id)) ?>" title="туристическая страна <?= SiteHelper::getTranslateForUrl( $item->country_id->name ) ?>"><?= $item->country_id->name ?></a><br/>
                туров: <b><?= $tourCount ?></b>
                <br/><br/>
                <a class="OrderRequest LPLink" href="#" title=связаться">связаться</a><br/>
            </div>
            <?= $item->description ?>
            <div id="orderInfo" class="displayNone">
                <b>Туристическая фирма - <?= $item->name ?></b><br/>
                <p>Для бронирования или уточнения информации по турам необходимо связатся с менеджером компании.</p>
                <p>
                    <?php if( $item->tel ) : ?>Телефон: <?= $item->tel ?><br/><?php endif; ?>
                    <?php if( $item->fax ) : ?>Факс: <?= $item->fax ?><br/><?php endif; ?>
                    <?php if( $item->email ) : ?>E-mail: <a href="mailto:<?= $item->email ?>"><?= $item->email ?></a><br/><?php endif; ?>
                    <?php if( $item->www ) : ?>Сайт: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                    <?php if( $item->address ) : ?><b>Адресс:</b> <?= $item->address ?><?php endif; ?>
                <div class="cMore">
                    <a href="#" class="orderClose">закрыть</a>
                </div>
                </p>
            </div>
            <div class="LParams">
                <b>Контактная информация:</b><br/>
                <?php if( $item->tel ) : ?>Телефон: <?= $item->tel ?><br/><?php endif; ?>
                <?php if( $item->fax ) : ?>Факс: <?= $item->fax ?><br/><?php endif; ?>
                <?php if( $item->email ) : ?>E-mail: <a href="mailto:<?= $item->email ?>"><?= $item->email ?></a><br/><?php endif; ?>
                <?php if( $item->www ) : ?>Сайт: <a target="_blank" href="<?= $item->www ?>"><?= $item->www ?></a><br/><?php endif; ?>
                <?php if( $item->address ) : ?><b>Адресс:</b><br/><?= $item->address ?><?php endif; ?>
            </div>
        </div>
        <div class="hr">&nbsp;</div>
        <?php if( sizeof($firmsTours)>0 ) : ?>
            <h2>Туры фирмы <?= $item->name ?></h2>
            <div class="ITBlock">
                <?php foreach( $firmsTours as $tour ) : ?>
                    <?php $this->widget("tourWidget", array( "item"=>$tour )) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if( sizeof($otherFirms)>0 ) : ?>
            <h2>Смотрите также</h2>
            <div class="ITBlock ITBFirms">
                <?php foreach( $otherFirms as $tour ) : ?>
                    <?php $this->widget("firmWidget", array( "item"=>$tour )) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


    </div>
    <?php $this->endCache(); endif;?>