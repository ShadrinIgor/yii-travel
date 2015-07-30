<?php

if( $categoryModel->id == 0 )
            $this->widget('addressLineWidget', array(
            'links'=>array(
                Yii::t("page", "Туристические объявления пользователей")
            )
        ));
    else
        $this->widget('addressLineWidget', array(
            'links'=>array(
                Yii::t("page", "частные объявления") => SiteHelper::createUrl( "/adsUsers" ),
                $categoryModel->name
            )
        ));

$sectionText = array(
    "ru"=>"tekstovka-dlya-stranicy-chastnye-obyavleniya",
    "en"=>"8525-tekstovka-page-for-personal-ads",
);
?>
<div id="catalogItems">
<div id="InnerText"  class="row tourItems">
    <?php if( $categoryModel->id == 0 ) : ?>
        <h1><?= Yii::t("page", "Частные туристические объявления"); ?></h1>
    <?php else : ?>
        <h1><?= $categoryModel->name ?><font>, <?= Yii::t("page", "туристические объявления"); ?></font></h1>
    <?php endif; ?>
    <?= SiteHelper::getAnimateText( $sectionText[ Yii::app()->getLanguage() ] ) ?>
    <?= $addModel->getMessage() ?>
    <div class="textAlignCenter">
        <a href="#" class="openDisplayNone addButton" title="<?= Yii::t("page", "добавить бесплатно туристическое объявление"); ?>">+ <?= Yii::t("page", "добавить объявление"); ?></a>
        <br/>

        <?php $countErrors = sizeof( $addModel->getErrors() );  ?>
        <div class="<?= $countErrors == 0 ? "displayNone " : "" ?> addForm">
            <?php if( !Yii::app()->user->isGuest ) : ?>
                <?= CHtml::errorSummary( $addModel ) ?>
                <form action="<?= SiteHelper::createUrl( "/adsUsers/save" ) ?>" enctype="multipart/form-data" method="post">
                    <div class="messageSummary"><?= Yii::t("page", "После сохранения вы сможете добавить большее количество фотографий."); ?></div>
                    <table class="tableForm" align="center" width="400">
                        <?= CCModelHelper::addForm( $addModel ) ?>
                        <tr>
                            <th colspan="2" class="textAlignCenter">
                                <input type="submit" name="add_new" value="<?= Yii::t("page", "Отправить"); ?>" />
                            </th>
                        </tr>
                    </table>
                </form>
                <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
            <?php else : ?>
                <center><b><?= Yii::t("page", "Для добавления необходимо авторизоваться"); ?></b></center>
                <?php
                Yii::app()->session['redirect'] = SiteHelper::createUrl("/adsUsers");
                $this->widget( "authWidget" )
                ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <?php
        foreach( $items as $item ) :
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a title="<?= SiteHelper::getStringForTitle( $item->name )?>" href="<?= SiteHelper::createUrl( "/adsUsers/description")."/".$item->slug ?>.html"><?= $item->name ?></a>
                    <?php if( $item->col>0 ) : ?><div class="floatRight rightInfo"><?= Yii::t("page", "просмотров"); ?>: <b><?= $item->col ?></b></div><?php endif; ?>
                </div>
                <div class="panel-body">
                    <div class="IImage img-rounded">
                            <?= ImageHelper::getAnimateImageBlock( $item, SiteHelper::createUrl( "/adsUsers/description")."/".$item->slug .".html", "", 0 ) ?>
                    </div>
                    <div class="blockquote blockquoteOrange floatRight width200 height146">
                        <?= Yii::t("page", "дата"); ?>: <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><br/>
                        <a href="<?= SiteHelper::createUrl("/adsUsers" )."/".$item->category_id->slug ?>.html"><?= $item->category_id->name ?></a><br/>
                        <?php if( $item->price > 0 ) : ?><?= Yii::t("page", "цена"); ?>: <b class="radColor"><?= $item->price ?></b><br/><?php endif; ?>
                        <?php if( $item->user_id->id == Yii::app()->user->getId() ) : ?><a href="<?= SiteHelper::createUrl("/user/items/description", array( "id"=>$item->id )) ?>"><?= Yii::t("page", "Редактировать"); ?></a><br/><?php endif; ?>
                    </div>
                    <div class="well well-lg"><div class="limitText">
                            <?= CCModelHelper::getLimitText( $item->description, "30" ) ?>
                    </div></div>
                </div>
            </div>
        <?php
        endforeach;
        if( !is_array( $items ) || sizeof( $items ) == 0 ) : ?>
            <center><br/><br/><b><?= Yii::t("page", "Список пока пуст, Ваше объявление может стать <u>первым</u> в данном разделе"); ?></b></center>
        <?php endif; ?>
    </div>
</div>
</div>