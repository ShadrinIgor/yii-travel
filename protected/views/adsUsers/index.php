<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        "Туристические объявления пользователей"
    )
));
?>

<div id="InnerText">
    <h1>Туристические объявления</h1>
    <?php
    foreach( $items as $item ) :
        ?>
        <div class="listItems">
            <?php if( $item->image ) : ?><div class="IImage"><a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/touristInfo/description" )."/".$item->slug ?>.html"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" width="200" alt="<?= $item->name ?>" /></a></div><?php endif; ?>
            <div class="LHeader">
                <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/touristInfo/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
            </div>
            <div class="LParams">
                <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
            </div>
            <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
        </div>
    <?php
    endforeach;
    if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
        <center>--- Список пуст ---</center>
    <?php endif; ?>
    <hr/>
    <div class="textAlignCenter">
        <a href="#" title="добавить бесплатно туристическое объявление">[ добавить объявление ]</a>
        <div>
            <?= CHtml::errorSummary( $addModel ) ?>
            <?= $addModel->getMessage() ?>
            <form action="<?= SiteHelper::createUrl( "/adsUsers" ) ?>" enctype="multipart/form-data" method="post">
                <table class="tableForm">
                    <?= CCModelHelper::addForm( $addModel, true, $this ) ?>
                    <tr>
                        <th colspan="2" class="textAlignCenter">
                            <input type="submit" name="add_new" value="Отправить" />
                        </th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>