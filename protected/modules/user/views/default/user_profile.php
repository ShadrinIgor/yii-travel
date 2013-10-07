<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        $user->name
    )
));

?>

<h1><?= $user->name ?></h1>

<table border="0" width="500" cellpadding="6" cellspacing="6" class="tableForm">
        <?php if( !empty( $user->image ) ) : ?>
            <tr>
                <td colspan="2" align="center"><img src="<?= $user->image ?>" /></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td align="right"><i>Имя:</i>&nbsp;</td>
            <td><?= $user->name ?></td>
        </tr>
        <tr>
            <td align="right"><i>Email:</i>&nbsp;</td>
            <td><?= $user->email ?></td>
        </tr>
        <?php if( !empty( $user->country)|| !empty( $user->country_other ) ) : ?>
            <tr>
                <td align="right"><i>Страна:</i>&nbsp;</td>
                <td><?= ( !empty( $user->country )  ) ? $user->country->name : $user->country_other ?></td>
            </tr>
        <?php endif; ?>
        <?php if( !empty( $user->city)  ) : ?>
        <tr>
            <td align="right"><i>Город:</i>&nbsp;</td>
            <td><?= $user->city->name ?></td>
        </tr>
        <?php endif; ?>

</table>

<?php if( sizeof( $user_tree ) >0 ) : ?>

<h2>Посаженные деревья</h2>
<div class="gallery">
    <?php
    $n=0;
    foreach( $user_tree as $tree ) :
        if( $n == 4 )break;
        $n++;
        ?>
        <div class="GItem">
            <a href="<?= SiteHelper::createUrl("/gardens/usertree", array( "id"=>$tree->id )) ?>" title=""><img src="<?= $tree->image ?>" alt="" /></a>
        </div>
        <?php endforeach; ?>
</div>
<br/>
<?php endif; ?>