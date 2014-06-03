<div id="innerPage">
<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
                    Yii::t("user", "мои фирмы")=>SiteHelper::createUrl( "/user/firms" ),
                    Yii::t("page", "Описание")
                  ),
));

$listComments = CatalogFirmsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setOrderBy("id DESC")->setLimit(50)->setCache(0));
$listService = CatalogFirmsService::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
$listItems = CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
$listBanners = CatalogFirmsBanners::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
$listTours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));

$tab = Yii::app()->request->getParam("tab", "description");

$tabArray = array("description" ,"ptours" ,"items" ,"service" ,"reclame" ,"pcomments" ,"counter");
if( !in_array( $tab, $tabArray ) )$tab = "description";
?>
<div class="sovetBlock"><a href="<?= SiteHelper::createUrl("/site/addFirm") ?>" title="<?= Yii::t("user_firm", "Как правильно добавить фирму?") ?>"><?= Yii::t("user_firm", "Как правильно добавить фирму?") ?></a></div>
<h1><font><?= Yii::t("user_firm", "Описание туристического агенства"); ?></font> <?= $item->id >0 ? " - ". $item->name : "" ?></h1>
    <div id="dopMenu">
        <a href="#" id="description" class="<?= $tab== "description" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Описание и галлерея"); ?></a>
        <?php if( $item->id >0 ) : ?>
            <a href="#" id="ptours" class="<?= $tab== "ptours" ? "ptours " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Туры компаниии"); ?>( <?= sizeof($listTours) ?> )</a>
            <a href="#" id="items" class="<?= $tab== "items" ? "items " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Акции и скидки"); ?>( <?= sizeof($listItems) ?> )</a>
            <a href="#" id="service" class="<?= $tab== "service" ? "service " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Дополнительные услуги"); ?>( <?= sizeof($listService) ?> )</a>
            <a href="#" id="reclame" class="<?= $tab== "reclame" ? "reclame " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Рекламный баннер"); ?>( <?= sizeof($listBanners) ?> )</a>
            <a href="#" id="pcomments" class="<?= $tab== "pcomments" ? "pcomments " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Отзывы/Сообщения"); ?>( <?= sizeof($listComments) ?> )</a>
            <a href="#" id="counter" class="<?= $tab== "counter" ? "counter " : "" ?>dopMenuPages"><?= Yii::t("user_firm", "Статистика посещаемости"); ?></a>
            <a href="<?= SiteHelper::createUrl( "/travelAgency/description")."/".$item->slug ?>.html" title="<?= Yii::t("user_firm", "Посмотреть как будет выглядеть персональная страница фирмы"); ?>"><?= Yii::t("user_firm", "Просмотреть страницу фирмы"); ?></a>
            <br/>
            <span><?= Yii::t("page", "статус"); ?>: <b class="publishStatus"><?= $item->active == 0 ? " ".Yii::t("user", "не опубликован")." " : " ".Yii::t("user", "опубликован")." " ?></b></span>
            <a href="#" class="publishLink linkButton" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl( "/user/firms/setPublish", array( "id"=>$item->id, "catalog"=>SiteHelper::getCamelCase( $item->tableName() ) ) ) ?>', '' );">
                <?php if( $item->active == 0 ) : ?><?= Yii::t("user", "Опубликовать на сайте ?") ?><?php endif; ?><?php if( $item->active == 1 ) : ?><?= Yii::t("user", "Снять с публикации ?") ?><?php endif; ?></a>
        <?php endif; ?>
    </div>
<?php echo CHtml::errorSummary($item); ?>
<?php if( !empty( $message ) ) : ?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
<?php if( $item->id > 0 ) : ?>
    <div class="textAlignCenter">
        <a href="<?= SiteHelper::createUrl("/user/tours/description", array( "fid"=>$item->id) ) ?>" class="addButton" title="+ <?= Yii::t("user_firm", "Добавить тур для Вашей компания"); ?>">+ <?= Yii::t("user_firm", "Добавить тур"); ?></a>
        <a href="<?= SiteHelper::createUrl("/user/firmItems/description", array( "fid"=>$item->id) ) ?>" class="addButton" title="+ <?= Yii::t("user_firm", "Добавить акцию или скидку для Вашей компания"); ?>">+ <?= Yii::t("user_firm", "Добавить акцию"); ?></a>
        <a href="<?= SiteHelper::createUrl("/user/firmBanners/description", array( "fid"=>$item->id) ) ?>" class="addButton" title="+ <?= Yii::t("user_firm", "Добавить БЕСПЛАТНЫЙ баннер"); ?>">+ <?= Yii::t("user_firm", "Добавить БЕСПЛАТНЫЙ баннер"); ?></a>
    </div>
<?php endif; ?>
<div id="counter_page" class="pageTab<?= $tab == "counter" ? " activePage" : " displayNone" ?>">
    <?php $this->renderPartial( "counter_page", array("item"=>$item ) ) ?>
</div>
<div id="pcomments_page" class="pageTab<?= $tab == "pcomments" ? " activePage" : " displayNone" ?>">
    <?php $this->renderPartial( "pcomments_page", array("item"=>$item, "items"=>$listComments) ) ?>
</div>
<div id="service_page" class="pageTab<?= $tab== "service" ? " activePage" : " displayNone" ?>">
    <?php $this->renderPartial( "service_page", array("item"=>$item, "items"=>$listService) ) ?>
</div>
<div id="items_page" class="pageTab<?= $tab == "items" ? " activePage" : " displayNone" ?>">
    <?php $this->renderPartial( "items_page", array("item"=>$item, "items"=>$listItems) ) ?>
</div>
<div id="reclame_page" class="pageTab<?= $tab == "reclame" ? " activePage" : " displayNone" ?>">
    <?php $this->renderPartial( "reclame_page", array("item"=>$item, "items"=>$listBanners) ) ?>
</div>
<div id="ptours_page" class="pageTab<?= $tab == "ptours" ? " activePage" : " displayNone" ?>">
    <?php $this->renderPartial( "ptours_page", array("item"=>$item, "items"=>$listTours) ) ?>
</div>
<div id="description_page" class="pageTab<?= $tab == "description" ? " activePage" : " displayNone" ?>">
    <?php if( $item->id == 0 ) : ?>
        <?= SiteHelper::getAnimateText( "tekst-dlya-stranica-dobavlenie-fimy" ) ?>
    <?php endif; ?>
    <div id="gallery">
        <h2>Галлерея</h2>
        <?= $gallMessage ? '<div class="messageSummary">'.$gallMessage.'</div>' : "" ?>
        <?php if( $item->id==0 ) : ?>
            <div class="messageSummary"><?= Yii::t("user", "После сохранения вы сможете добавить фотографии.") ?></div>
        <?php else : ?>
        <form action="" method="post">
            <?php echo CHtml::errorSummary($addImage); ?><br>
            <div class="listGallery">
                <?php if( sizeof( $listGallery ) == 0 ) : ?><div class="textAlignCenter"><?= Yii::t("page", "Список пуст"); ?></div><?php endif; ?>
                <?php foreach( $listGallery as $gall ) : ?>
                    <div class="LGItem">
                        <div>
                            <a href="<?= $gall->image ?>" data-lightbox="roadtrip"><img src="<?= ImageHelper::getImage( $gall->image, 3 ) ?>" /></a>
                        </div>
                        <input type="text" name="ITitle[<?= $gall->id ?>]" value="<?= $gall->name ?>" placeholder="<?= Yii::t("page", "описание фото") ?>" /><br/>
                        <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "gall_id"=>$gall->id, "action"=>"delGallery")) ?>"><?= Yii::t("user", "Удалить") ?></a>&nbsp;
                    </div>
                <?php endforeach; ?>

            </div>
            <?php if( sizeof( $listGallery )>0 ) : ?>
                <div class="textAlignCenter">
                    <input type="submit" name="saveTitle" value="<?= Yii::t("user", "Сохранить описание") ?>" />&nbsp;
                </div>
            <?php endif; ?>
        </form>
        <div class="textAlignCenter">
            <input type="button" class="openDisplayNone" value="<?= Yii::t("user", "Добавить фото") ?>" />
        </div>
        <div class="<?php if( empty( $_POST["sendGallery"] ) || $addImage->formMessage ) :?>displayNone <?php endif; ?>addForm">
            <?= CHtml::form("","post", array("enctype"=>"multipart/form-data")) ?>
            <table class="tableListItems">
                <tr>
                    <td colspan="2"><input type="file" name="CatGallery[images][]" multiple="true" /></td>
                </tr>
                <tr>
                    <td>
                        <b><?= Yii::t("page", "Внимание!"); ?></b><br/>
                        <?= Yii::t("page", "Вы можете добавлять несколько фотографий одновременно."); ?><br/>
                        <i><?= Yii::t("page", "( Для этого необходимо нажать кнопку [ ctrl ] и выбрать поочередно необходимые фотографии )"); ?></i>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="textAlignCenter">
                        <?= CHtml::submitButton( Yii::t("user", "Добавить"), array("name"=>"sendGallery") ) ?>
                    </td>
                </tr>
            </table>
            <?= CHtml::endForm(); ?>
            </form>
            <?php endif;?>
        </div>
    </div>
    <br/>

    <form action="" method="post" enctype="multipart/form-data">
        <?php $item->getMessage() ?>
    <table class="tableForm">
        <?=
            CCModelHelper::addForm( $item )
        ?>
        <tr>
            <td></td>
            <td>
                <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()) ?>';" name="update" value="<?= Yii::t("page", "Отмена") ?>" />&nbsp;
                <input type="submit" name="update" value="<?= Yii::t("user", "Сохранить") ?>" />
            </td>
        </tr>
    </table>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
</form>
    <?php $this->widget( "formNoteWidget" ) ?>
</div>

</div>

