<div id="innerPage">
<?php
    $this->widget('addressLineWidget', array(
        'links'=>array( "Рабочий стол" ),
    ));
?>
<h1>Рабочий стол</h1>
<form action="" method="post">
    <?= $userModel->getMessage();  ?>
    <div class="overflowHidden">
        <?php foreach( $items as $item ) : ?>
            <div class="DLItem">
                <div class="TImage"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt=""/></div>
                <input type="radio" name="desktopID" value="<?= $item->id ?>" id="item_<?= $item->id ?>" <?= ( $userModel->desktop && $userModel->desktop->id == $item->id ) ? "checked=\"checked\"" : "" ?> /><label for="item_<?= $item->id ?>"><?= $item->name ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="textAlignCenter"><input type="submit" name="desktop_save" value="Сохранить" /></div>
</form>
</div>