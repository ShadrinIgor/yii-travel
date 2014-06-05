<h1>Галерея</h1>

<div id="galleryCountry">
<?php foreach( $list_country as $country ):
    if( CatalogGardens::count(DBQueryParamsClass::CreateParams()->setConditions("country=:country")->setParams(array(":country"=>$country->id))) >0  ) : ?>
    <div class="GC_items">
        <div class="GCTitle"><?= $country->name ?></div>
        <div class="GGardens">
        <?php
            $listCardens = CatalogGardens::findByAttributes( array( "country"=>$country->id ) );
            foreach( $listCardens as $garden ) : ?>
                <div class="GGTitle"><?= $garden->name ?></div>
                    <div class="GPlaces">
                        <?php
                            $lisPlaces = CatalogGardensPlaces::findByAttributes( array( "garden_id"=>$garden->id ) );
                            foreach( $lisPlaces as $place ) :
                                $countTree = CatalogGardensTree::count( DBQueryParamsClass::CreateParams()->setConditions("place_id=:place_id")->setParams(array(":place_id"=>$place->id)));
                                $countImages = CatGallery::count( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams(array(":catalog"=>"catalog_gardens_places", ":item_id"=>$place->id)));
                                ?>
                                <div clas="GPItems<?php if( $id>0 && $id == $place->id ) : ?> GPSel<?php endif; ?>"><a href="<?= SiteHelper::createUrl("/gallery/index", array("id"=>$place->id)) ?>" title="<?= $country->name ?>, <?= $garden->name ?>, <?= $place->name ?> Галерея"><?= $place->name ?> ( <?= $countTree."/".$countImages ?> )</a></div>
                            <?php endforeach; ?>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php  endif;
    endforeach; ?>
</div>
<br/>
<?php if( sizeof( $images ) >0 || sizeof( $trees )>0 ) : ?>
<div id="gallery" class="listAll">
    <?php if( sizeof($images)>0 ) : ?><h2>Фотографии</h2><?php endif; ?>
    <?php
    $n=0;
    foreach( $images as $foto ) :
        $n++;
        ?>
        <div class="GItem">
            <a href="#" title=""><img src="<?= $foto->image ?>" alt="<?= $foto->name ?>" /></a>
        </div>
    <?php endforeach; ?>

    <?php if( sizeof($trees)>0 ) : ?><h2>Деревья</h2><?php endif; ?>
    <?php
    $n=0;
    foreach( $trees as $foto ) :
        $n++;
        ?>
        <div class="GItem">
            <a href="<?= SiteHelper::createUrl("/gardens/usertree", array( "id"=>$foto->id )) ?>" title="<?= $foto->garden_id->name." ".$foto->place_id->name." ".$foto->type_id->name ?>"><img src="<?= $foto->image ?>" alt="<?= $foto->name ?>" /></a>
        </div>
    <?php endforeach; ?>

</div>
<?php endif; ?>
