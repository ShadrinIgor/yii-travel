<div class="BannerBlock">
    <?php if( $banner->type_id->id ==1 ) : // Статичный банер ?>
        <a href="<?= $banner->href ?>" title="<?= $banner->name ?>"><img src="<?= $banner->image ?>" alt="<?= $banner->name ?>" /></a>
    <?php elseif( $banner->type_id->id ==3 ) : // Банер размещенный на внешнем источнике ?>
        <a href="<?= $banner->href ?>" title=""><img src="<?= $n=0;/* этот бункционал не доделан */ ?>" alt="" /></a>
    <?php else : // Флешь банер

     if( $banner->width>0 )$width = ' width="'.$banner->width.'"';
        elseif( !$banner->height )
            $width = ' width="400"';
        else
            $width = "";

     if( $banner->height>0 ) $height = ' height="'.$banner->height.'"';
        elseif( !$banner->width )
            $height = ' height="90"';
         else
            $height = "";
    ?>
    <?php if( $banner->href ) : ?><a href="<?= $banner->href ?>" title=""> <?php endif; ?>
        <object align="center" <?= $width ?> <?= $height ?> classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
           <param value="<?= $banner->image ?>" name="movie"/>
           <embed  <?= $width ?> <?= $height ?> src="<?= $banner->file ?>" type="application/x-shockwave-flash"/>
        </object>
    <?php if( $banner->href ) : ?></a><?php endif; ?>
    <?php endif; ?>
</div>