<div class="IBItem">
    <div class="IBIImage">
        <a href="<?= SiteHelper::createUrl("hotels/", array( "slug"=>SiteHelper::getSlug( $item ), "id"=>$item->id )) ?>" title=""><img src="<?= ImageHelper::getImage($item->image, 2) ?>" alt="" /></a>
    </div>
    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><= $item->col ></b></div><?php endif; ?>
    <br/><a href="<?= SiteHelper::createUrl("/hotels")."/".$item->slug ?>" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
    <div class="LParams">
        <?php if( $item->level >0 ) : ?><img width="65" src="<?= SiteHelper::getStarsLevel( $item->level ) ?>" title="отель <?= $item->level ?>*" /><br/><?php endif; ?>
        <a href="<?= SiteHelper::createUrl("/hotels/country")."/".$item->country_id->slug ?>" title="отели <?= $item->country_id->name_2 ?>"><?= $item->country_id->name ?></a><br/>
        <a href="<?= SiteHelper::createUrl("/hotels/city")."/".$item->city_id->slug ?>" title="отели <?= $item->city_id->name ?>"><?= $item->city_id->name ?></a>
    </div>
</div>
