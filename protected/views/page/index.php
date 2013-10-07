<div id="PageText">
    <?php
    Yii::app()->page->title = $page->name;

    $this->widget('addressLineWidget', array(
        'links'=>
            array(
                $page->name,
                )
    ));
    ?>
    <?php Yii::app()->banners->getBannerByCategory( 1 ); ?>

    <h1><?= $page->name ?></h1>
    <?= $page->description ?>
</div>