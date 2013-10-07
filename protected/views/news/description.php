<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Новости"=>SiteHelper::createUrl("/news"),
        $content->name
    )
));
?>

<h1><?= $content->name ?></h1>
<?php if( $content->image ) : ?><img src="<?= $content->image ?>" width="250" alt="" /><?php endif; ?>
<?= $content->description ?>