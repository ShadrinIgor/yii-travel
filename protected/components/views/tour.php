<div class="IBItem">
    <div class="IBIImage">
        <a href="#" title=""><img src="<?= ImageHelper::getImage($tour->image, 2) ?>" alt="" /></a>
    </div>
    <?php if( $tour->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $tour->col ?></b></div><?php endif; ?>
    <a href="<?= SiteHelper::createUrl("tour/", array( "slug"=>$tour->slug, "id"=>$tour->id )) ?>" title="<?= $tour->name ?>"><?= SiteHelper::getSubTextOnWorld( $tour->name, 100 ) ?></a><br/>
    <?php if( $tour->price >0 ) : ?><p>цена:<b><?= $tour->price ?></b></p><?php endif; ?>
    <?= SiteHelper::getSubTextOnWorld( $tour->description, 180 ) ?>
    <div class="LParams">
        <a href="<?= SiteHelper::createUrl("firms/", array("id"=>$tour->firm_id->id)) ?>" title="туристическая фирма <?= $tour->firm_id->name ?>"><?= $tour->firm_id->name ?></a>
    </div>
</div>
