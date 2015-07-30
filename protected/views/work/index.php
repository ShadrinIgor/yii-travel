<?php

if( $categoryModel->id == 0 )
            $this->widget('addressLineWidget', array(
            'links'=>array(
                Yii::t("page", "Работа в туристической сфере")
            )
        ));
    else
        $this->widget('addressLineWidget', array(
            'links'=>array(
                Yii::t("page", "Работа в туристической сфере") => SiteHelper::createUrl( "/work" ),
                $categoryModel->name
            )
        ));
?>

<div id="catalogItems">
    <div id="InnerText" class="row tourItems">
        <?php if( $categoryModel->id == 0 ) : ?>
            <h1><?= Yii::t("page", "Работа в туристической сфере"); ?></h1>
        <?php else : ?>
            <h1><?= $categoryModel->name ?><font>, <?= Yii::t("page", "Работа в туристической сфере"); ?></font></h1>
        <?php endif; ?>
        <h2><?= Yii::t("page", "Вакансии"); ?></h2>
        <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/work/description" ) ?>" class="addButton" title="<?= Yii::t("page", "добавить бесплатно вакансию в  туристической сфере"); ?>">Разместить Свою вакансию</a></div>
        <div class="row">
            <?php foreach( $items as $item ) :?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/work/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                        <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров"); ?>: <b><?= $item->col ?></b></div><?php endif; ?>
                    </div>
                    <div class="panel-body">
                        <div class="IImage img-rounded">
                            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/adsUsers/description")."/".$item->slug .".html", "", 0 ) ?>
                        </div>
                        <div class="blockquote blockquoteOrange floatRight width200 height146">
                            <?= Yii::t("page", "дата"); ?>: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
                            <a href="<?= SiteHelper::createUrl("/work" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
                            <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                            <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/work/description", array( "id"=>$item->id )) ?>"><?= Yii::t("page", "Редактировать"); ?></a><br/><?php endif; ?>
                        </div>
                        <div class="well well-lg"><div class="limitText">
                                <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
                        </div></div>
                    </div>
                </div>
            <?php
            endforeach;
            if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
                <?= Yii::t("page", "Список пока пуст, Ваше объявление может стать <u>первым</u> в данном разделе"); ?></b></center>
            <?php endif; ?>
        </div>

        <h2><?= Yii::t("page", "Резюме"); ?></h2>
        <div class="textAlignCenter"><a href="<?= SiteHelper::createUrl( "/user/resume/description" ) ?>" class="addButton" title="<?= Yii::t("page", "добавить бесплатно резюме в туристической сфере"); ?>">Разместить Свое резюме</a></div>
        <div class="row">
            <?php foreach( $itemsResume as $item ) :?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/work/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                        <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров"); ?>: <b><?= $item->col ?></b></div><?php endif; ?>
                    </div>
                    <div class="panel-body">
                        <div class="IImage img-rounded">
                            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/work/description")."/".$item->slug .".html", "", 0 ) ?>
                        </div>
                        <div class="blockquote blockquoteOrange floatRight width200 height146">
                            <?= Yii::t("page", "дата"); ?>: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
                            <a href="<?= SiteHelper::createUrl("/work" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
                            <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                            <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/resume/description", array( "id"=>$item->id )) ?>"><?= Yii::t("page", "Редактировать"); ?></a><br/><?php endif; ?>
                        </div>
                        <div class="well well-lg"><div class="limitText">
                                <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
                            </div></div>
                    </div>
                </div>
            <?php
            endforeach;
            if( !is_array( $itemsResume ) || sizeof( $itemsResume ) == 0 ) : ?>
                <center><b><?= Yii::t("page", "Список пока пуст, Ваше объявление может стать <u>первым</u> в данном разделе"); ?></b></center>
            <?php endif; ?>
        </div>
    </div>
</div>