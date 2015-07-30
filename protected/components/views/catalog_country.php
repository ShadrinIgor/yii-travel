<?php foreach( $items as $item ) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a title="<?= $item->name ?>, <?= Yii::t("page", "туристическая информация, фирмы, туры, достопримечательности") ?>" href="<?= SiteHelper::createUrl( "/countryPage", array( "country"=>$item->slug ) ) ?>"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров") ?>: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="panel-body">
            <?php if( $item->image ) : ?><div class="IImage img-rounded"><a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( "/countryPage", array( "country"=>$item->slug ) ) ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></a></div><?php endif; ?>
            <div class="blockquote blockquoteOrange floatRight">
            <?php
                $tours = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array( ":country_id"=>$item->id )) );
                $firms = CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array( ":country_id"=>$item->id )) );
            ?>
                <?php if( $tours>0 ) : ?><?= Yii::t("page", "Туров") ?>: <b><?= $tours ?></b><br/><?php endif; ?>
                <?php if( $firms>0 ) : ?><?= Yii::t("page", "Фирмы") ?>: <b><?= $firms ?></b><br/><?php endif; ?>
            </div>
            <div class="well well-lg"><div class="limitText">
                <?= CCModelHelper::getLimitText( $item->description, "50" ) ?>
            </div></div>
        </div>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- <?= Yii::t("page", "Список пуст" )?> ---</center>
<?php endif; ?>