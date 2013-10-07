<?php
foreach( $items as $item ) :
    ?>
    <div class="listItems">
        <?php if( $item->image ) : ?><div class="IImage"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></div><?php endif; ?>
        <div class="LHeader">
            <a title="<?= $item->name ?>" href="<?= SiteHelper::createUrl( $url."/", array(  "id"=>$item->id )) ?>"><?= $item->name ?></a>
            <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
        </div>
        <div class="LParams">
        <?php
            $tours = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array( ":country_id"=>$item->id )) );
            $firms = CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array( ":country_id"=>$item->id )) );
        ?>
            <?php if( $tours>0 ) : ?>Туров: <b><?= $tours ?></b><br/><?php endif; ?>
            <?php if( $firms>0 ) : ?>Фирмы: <b><?= $firms ?></b><br/><?php endif; ?>
        </div>
        <?= CCmodelHelper::getLimitText( $item->description, "30" ) ?>
    </div>
<?php
endforeach;
if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
    <center>--- Список пуст ---</center>
<?php endif; ?>