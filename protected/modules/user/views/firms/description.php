<div id="innerPage">
<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
                    "Мои фирмы"=>SiteHelper::createUrl( "/user/firms" ),
                    "Описание"
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
<h1>Описание туристической фирмы <?= $item->id >0 ? " - ". $item->name : "" ?></h1>
    <div id="dopMenu">
        <a href="#" id="description" class="<?= $tab== "description" ? "activeDM " : "" ?>dopMenuPages">Описание и галлерея</a>
        <a href="#" id="ptours" class="<?= $tab== "ptours" ? "ptours " : "" ?>dopMenuPages">Туры компаниии( <?= sizeof($listTours) ?> )</a>
        <a href="#" id="items" class="<?= $tab== "items" ? "items " : "" ?>dopMenuPages">Акции и скидки( <?= sizeof($listItems) ?> )</a>
        <a href="#" id="service" class="<?= $tab== "service" ? "service " : "" ?>dopMenuPages">Дополнительные услуги( <?= sizeof($listService) ?> )</a>
        <a href="#" id="reclame" class="<?= $tab== "reclame" ? "reclame " : "" ?>dopMenuPages">Рекламный баннер( <?= sizeof($listBanners) ?> )</a>
        <a href="#" id="pcomments" class="<?= $tab== "pcomments" ? "pcomments " : "" ?>dopMenuPages">Отзывы/Сообщения( <?= sizeof($listComments) ?> )</a>
        <a href="#" id="counter" class="<?= $tab== "counter" ? "counter " : "" ?>dopMenuPages">Статистика посещаемости</a>
        <a href="<?= SiteHelper::createUrl( "/travelAgency/description")."/".$item->slug ?>.html" title="Посмотреть как будет выглядеть персональная страница фирмы">Просмотреть страницу фирмы</a>
    </div>
<?php echo CHtml::errorSummary($item); ?>
<?php if( !empty( $message ) ) : ?>
    <div class="messageSummary"><?= $message ?></div>
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
    <div id="gallery">
        <h2>Галлерея</h2>
        <?= $gallMessage ? '<div class="messageSummary">'.$gallMessage.'</div>' : "" ?>
        <?php if( $item->id==0 ) : ?>
            <div class="messageSummary">После сохранения вы сможете добавить фотографии.</div>
        <?php else : ?>
        <form action="" method="post">
            <?php echo CHtml::errorSummary($addImage); ?><br>
            <div class="listGallery">
                <?php if( sizeof( $listGallery ) == 0 ) : ?><div class="textAlignCenter">Список пуст</div><?php endif; ?>
                <?php foreach( $listGallery as $gall ) : ?>
                    <div class="LGItem">
                        <div>
                            <a href="<?= $gall->image ?>" data-lightbox="roadtrip"><img src="<?= ImageHelper::getImage( $gall->image, 3 ) ?>" /></a>
                        </div>
                        <input type="text" name="ITitle[<?= $gall->id ?>]" value="<?= $gall->name ?>" placeholder="описание фото" /><br/>
                        <a href="<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description", array("id"=>$item->id, "gall_id"=>$gall->id, "action"=>"delGallery")) ?>">Удалить</a>&nbsp;
                    </div>
                <?php endforeach; ?>

            </div>
            <?php if( sizeof( $listGallery )>0 ) : ?>
                <div class="textAlignCenter">
                    <input type="submit" name="saveTitle" value="Сохранить описание" />&nbsp;
                </div>
            <?php endif; ?>
        </form>
        <div class="textAlignCenter">
            <input type="button" class="openDisplayNone" value="Добавить фото" />
        </div>
        <div class="<?php if( empty( $_POST["sendGallery"] ) || $addImage->formMessage ) :?>displayNone <?php endif; ?>addForm">
            <?= CHtml::form("","post", array("enctype"=>"multipart/form-data")) ?>
            <table class="tableListItems">
                <tr>
                    <td colspan="2"><input type="file" name="CatGallery[images][]" multiple="true" /></td>
                </tr>
                <tr>
                    <td>
                        <b>Внимание!</b><br/>
                        Вы можете добавлять несколько фотографий одновременно.<br/>
                        <i>( Для этого необходимо нажать кнопку [ ctrl ] и выбрать поочередно необходимые фотографии )</i>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="textAlignCenter">
                        <?= CHtml::submitButton( "Добавить", array("name"=>"sendGallery") ) ?>
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
    <table class="tableForm">
        <?=
            CCModelHelper::addForm( $item )
        ?>
        <tr>
            <td></td>
            <td>
                <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/user/".Yii::app()->controller->getId()) ?>';" name="update" value="Отмена" />&nbsp;
                <input type="submit" name="update" value="Сохранить" />
            </td>
        </tr>
    </table>
    <?php $this->widget( "formNoteWidget", array( "type"=>"requireFields" ) ) ?>
</form>
    <?php $this->widget( "formNoteWidget" ) ?>
</div>

</div>

