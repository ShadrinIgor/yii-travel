<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
            'Новости'
            )
    ));
?>
<div id="catalogItems">
<h1>Новости</h1>
<?php foreach( $content as $news ) :
    //echo $news->image."*";
    ?>
    <div class="listItems">
        <div class="LIHeader">
            <b><a title="<?= $news->name ?>" href="<?= SiteHelper::createUrl("/news/index", array("id"=>$news->id)) ?>"><?= $news->name ?></a></b>
        </div>
        <?php if( $news->image ) : ?><img src="<?= $news->image ?>" width="200" alt="<?= $news->name ?>" /><?php endif; ?>
        <?= CCmodelHelper::getLimitText( $news->description, "120" ) ?>
    </div>
<?php endforeach; ?>
</div>