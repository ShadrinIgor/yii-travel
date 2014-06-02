<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( Yii::t("user", "Рабочий стол" ) ),
    ));
?>
<h1><?= Yii::t("user", "Рабочий стол"); ?></h1>
<form action="" method="post">
    <?= $userModel->getMessage();  ?>
    <div class="overflowHidden textAlignCenter">
        <?php foreach( $items as $item ) : ?>
            <div class="DLItem">
                <div class="TImage"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt=""/></div>
                <input type="radio" name="desktopID" value="<?= $item->id ?>" id="item_<?= $item->id ?>" <?= ( $userModel->desktop && $userModel->desktop->id == $item->id ) ? "checked=\"checked\"" : "" ?> /><label for="item_<?= $item->id ?>"><?= $item->name ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="textAlignCenter"><input type="submit" name="desktop_save" value="<?= Yii::t("user", "Сохранить"); ?>" /></div>
</form>
</div>