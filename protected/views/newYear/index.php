<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
               Yii::t("page", "Туры")
            )
    ));

?>
<div id="catalogItems">
<?php foreach( $country as $item ) : ?>
    <div class="panel panel-success">
        <div class="panel-heading"><?= $item->name ?></div>
        <div class="panel-body">

        </div>
    </div>
<?php endforeach; ?>
</div>