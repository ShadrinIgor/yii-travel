<?php

if( $categoryModel->id == 0 )
            $this->widget('addressLineWidget', array(
            'links'=>array(
                "Туристические объявления пользователей"
            )
        ));
    else
        $this->widget('addressLineWidget', array(
            'links'=>array(
                "частные объявления" => SiteHelper::createUrl( "/adsUsers" ),
                $categoryModel->name
            )
        ));
?>

<div id="InnerText">
    <?php if( $categoryModel->id == 0 ) : ?>
        <h1>Частные туристические объявления</h1>
    <?php else : ?>
        <h1><?= $categoryModel->name ?><font>, туристические объявления</font></h1>
    <?php endif; ?>

    <?= $addModel->getMessage() ?>
    <div class="textAlignCenter">
        <a href="#" class="openDisplayNone addButton" title="добавить бесплатно туристическое объявление">+ добавить объявление</a>
        <br/>

        <?php $countErrors = sizeof( $addModel->getErrors() );  ?>
        <div class="<?= $countErrors == 0 ? "displayNone " : "" ?> addForm">
            <?php if( !Yii::app()->user->isGuest ) : ?>
                <?= CHtml::errorSummary( $addModel ) ?>
                <form action="<?= SiteHelper::createUrl( "/adsUsers/save" ) ?>" enctype="multipart/form-data" method="post">
                    <table class="tableForm" align="center" width="400">
                        <?= CCModelHelper::addForm( $addModel ) ?>
                        <tr>
                            <th colspan="2" class="textAlignCenter">
                                <input type="submit" name="add_new" value="Отправить" />
                            </th>
                        </tr>
                    </table>
                </form>
            <?php else : ?>
                <center><b>Для добавления необходимо авторизоваться</b></center>
                <?php
                Yii::app()->session['redirect'] = SiteHelper::createUrl("/adsUsers");
                $this->widget( "authWidget" )
                ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
    foreach( $items as $item ) :
        ?>
        <div class="listItems">
            <?php
            if( !$item->image )$countImages = 5;
            else $countImages = 4;

            $listImages = ImageHelper::getImages( $item, $countImages );
            if( sizeof( $listImages ) >0 || $item->image ) : ?>
                <div class="listItemsImages">
                    <?php if( $item->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="" /></div><?php endif; ?>
                    <?php
                    if( $item->image )$i=2;
                        else $i=1;

                    foreach( $listImages as $LItem ) :
                        if( $i == 1 )$imageSize = 2;
                               else $imageSize = 3;
                    ?>
                        <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, $imageSize ) ?>" alt="" /></div>
                    <?php
                        $i++;
                        endforeach;
                    ?>
                </div>
            <?php endif;?>
            <div class="LHeader">
                <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/adsUsers/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
            </div>
            <div class="LParams">
                дата: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
                <a href="<?= SiteHelper::createUrl("/adsUsers" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
                <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/items/description", array( "id"=>$item->id )) ?>">Редактировать</a><br/><?php endif; ?>
            </div>
            <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
        </div>
    <?php
    endforeach;
    if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
        <center>--- Список пуст ---</center>
    <?php endif; ?>
    <hr/>

</div>