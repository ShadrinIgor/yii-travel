<?php
if( sizeof( $images ) >0 ) : ?>
<div id="gallery" class="listAll">
    <ul id="lightBox">
    <?php if( sizeof($images)>0 ) : ?><h2><?= Yii::t("page", "Фотографии" ) ?></h2><?php endif; ?>
    <?php
    $n=0;
    foreach( $images as $foto ) :
        $n++;
        ?>
        <li class="GItem">
            <a href="<?= $foto->image ?>" rel="lightbox" title="<?= $foto->name ?>"><img src="<?= $foto->image ?>" alt="<?= $foto->name ?>" /></a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
