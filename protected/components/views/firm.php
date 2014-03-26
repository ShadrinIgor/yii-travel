<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$tour->slug.".html" ?>" title=""><img src="<?= ImageHelper::getImage($tour->image, 2) ?>" alt="" /></a>
    </div>
    <?php if( $tour->price >0 ) : ?><p><?= $tour->price ?></p><?php endif; ?>
    <!--php if( $tour->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><= $tour->col ></b></div><php endif; -->
    <br/><a href="<?= SiteHelper::createUrl("/travelAgency/description")."/".$tour->slug ?>.html" title="<?= $tour->name ?>"><?= $tour->name ?></a><br/>
    <div class="LParams">
        Туров: <b><?= $tourCounts ?></b>
    </div>
</div>
