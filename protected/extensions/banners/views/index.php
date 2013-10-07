<div class="topBaner">
    <?php if( $banner->type!=1 ) : ?>
    <a href="<?= $href ?> title=""><img src="<?= $banner ?>" alt="" /></a>
    <?php else :
     $width = ( $banner->width ) ? ' width="'.$banner->width.'"' : ' width="400"';
     $height = ( $banner->height ) ? ' height="'.$banner->height.'"' : ' height="90"';
    ?>
    <a href="<?= $banner->href ?>" title="">
        <object <?= $width ?> <?= $height ?> classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
           <param value="<?= $banner->image ?>" name="movie"/>
           <embed  <?= $width ?> <?= $height ?> src="<?= $banner->image ?>" type="application/x-shockwave-flash"/>
        </object></a>
    <?php endif; ?>
</div>