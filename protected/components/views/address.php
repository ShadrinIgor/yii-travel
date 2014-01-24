<div id="Address">
<?php foreach( $links as $key=>$value ) : ?>
    <?php if( !empty( $key ) ) : ?>
        <a href="
            <?php
                if( !is_array( $value ) ) echo $value;
                    else echo SiteHelper::createUrl( $value[0], $value[1] );
            ?>" title="<?= $key ?>"><?= $key ?></a>
        <span>... </span>
    <?php else : ?>
        <span><?= $value ?></span>
    <?php endif; ?>
<?php endforeach; ?>
</div>