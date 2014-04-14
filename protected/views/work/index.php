<?php

if( $categoryModel->id == 0 )
            $this->widget('addressLineWidget', array(
            'links'=>array(
                "Работа в туристичестической сфере"
            )
        ));
    else
        $this->widget('addressLineWidget', array(
            'links'=>array(
                "Работа в туристичестической сфере" => SiteHelper::createUrl( "/work" ),
                $categoryModel->name
            )
        ));
?>

<div id="InnerText">
    <?php if( $categoryModel->id == 0 ) : ?>
        <h1>Работа в туристичестической сфере</h1>
    <?php else : ?>
        <h1><?= $categoryModel->name ?><font>, работа в туристичестической сфере</font></h1>
    <?php endif; ?>
    <h2>Вакансии</h2>
    <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/work/description" ) ?>" class="addButton" title="добавить бесплатно вакансию в  туристической сфере">+ добавить вакансию</a></div>
    <?php foreach( $items as $item ) :?>
        <div class="listItems">
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/work/description")."/".$item->slug .".html" ) ?>
            <div class="LHeader">
                <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/work/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
            </div>
            <div class="LParams">
                дата: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
                <a href="<?= SiteHelper::createUrl("/work" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
                <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/work/description", array( "id"=>$item->id )) ?>">Редактировать</a><br/><?php endif; ?>
            </div>
            <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
        </div>
    <?php
    endforeach;
    if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
        <center><br/><br/><b>Список пока пуст, Ваше объявление может стать <u>первым</u> в данном разделе</b></center>
    <?php endif; ?>

    <h2>Резюме</h2>
    <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/resume/description" ) ?>" class="addButton" title="добавить бесплатно резюме в туристической сфере">+ добавить резюме</a></div>
    <?php foreach( $itemsResume as $item ) :?>
        <div class="listItems">
            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/work/description")."/".$item->slug .".html" ) ?>
            <div class="LHeader">
                <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/work/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo">просмотров: <b><?= $item->col ?></b></div><?php endif; ?>
            </div>
            <div class="LParams">
                дата: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
                <a href="<?= SiteHelper::createUrl("/work" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
                <?php if( $item->price > 0 ) : ?>цена: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/resume/description", array( "id"=>$item->id )) ?>">Редактировать</a><br/><?php endif; ?>
            </div>
            <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
        </div>
    <?php
    endforeach;
    if( !is_array( $itemsResume ) || sizeof( $itemsResume ) == 0 ) : ?>
        <center><br/><br/><b>Список пока пуст, Ваше объявление может стать <u>первым</u> в данном разделе</b></center>
    <?php endif; ?>
</div>