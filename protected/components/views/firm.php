<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("firms/", array( "slug"=>$tour->slug, "id"=>$tour->id )) ?>" title=""><img src="<?= ImageHelper::getImage($tour->image, 2) ?>" alt="" /></a>
    </div>
    <?php if( $tour->price >0 ) : ?><p><?= $tour->price ?></p><?php endif; ?>
    <!--php if( $tour->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><= $tour->col ></b></div><php endif; -->
    <br/><a href="<?= SiteHelper::createUrl("firms/", array( "slug"=>$tour->slug, "id"=>$tour->id )) ?>" title="<?= $tour->name ?>"><?= $tour->name ?></a><br/>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("tours/", array("firms"=>$tour->id)) ?>" title="туров <?= $tour->name ?>">Туров: <b><?= $tourCounts ?></b></a>
    </div>
</div>
