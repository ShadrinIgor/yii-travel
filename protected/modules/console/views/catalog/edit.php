<div id="Address">
    <a href="<?= SiteHelper::createUrl( "/console" ) ?>">главная</a> ... <a href="<?= SiteHelper::createUrl( "/console/catalog", $arrayParams ) ?>">назад к списку</a>
</div>
<h1>Редактирование - <?= $form->name ?></h1>
<form action="<?= SiteHelper::createUrl("/console/catalog/update", array( "id"=>$form->id)).$controller->params?>" method="post" onsubmit="submitForm();"  enctype="multipart/form-data">
<?php
    echo CHtml::errorSummary($form);
    if( !empty( $message ) ):?><div class="messageSummary"><?= $message ?></div><?php endif;?>
<br>

<table align="center" class="editTable">
    <?= CCmodelHelper::addForm( $form ); ?>
</table>
<br/>
<div id="relationItems">
    <?php foreach( $form->relations() as $relation ) : ?>
        <?php if( $relation[0] == CCModel::HAS_MANY || $relation[0] == CCModel::MANY_MANY ) : // Связь многие ко многим или многоие к одному?>
            <h3><?= $relation[1] ?></h3>
            <div class="listItems">
                <?php
                    // Собираем ID значание из связанной таблицы в масив чтобы потом проверять  м т
                    $listValue = array();
                    foreach( CatRelations::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("leftId=:leftId AND leftClass=:leftClass AND rightClass=:rightClass")->setParams( array( ":leftId"=>$form->id, ":leftClass"=>SiteHelper::getCamelCase( $form->tableName() ), ":rightClass"=>$relation[1] ) )->setCache(0) ) as $itemValue )
                        $listValue[] = $itemValue->rightId;

                    $relationTable = $relation[1];
                    if( !property_exists( $relationTable, "owner" ) )$listItems = $relationTable::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy("name")->setLimit(-1)->setCache(0) );
                                 else $listItems = $relationTable::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("owner=0")->setOrderBy("name")->setLimit(-1)->setCache(0) );
                    foreach( $listItems as $relationItem ) :
                ?>
                    <div><input type="checkbox" <?= in_array( $relationItem->id, $listValue ) ? "checked=\"checked\"" : "" ?> name="<?= SiteHelper::getCamelCase( $form->tableName() )."[".$relation[1] ?>][]" value="<?= $relationItem->id ?>" id="item_<?= $relation[1] ?>_<?= $relationItem->id ?>" /><label for="item_<?= $relation[1] ?>_<?= $relationItem->id ?>"><?= $relationItem->name ?></label></div>
                    <?php if( property_exists( $relationTable, "owner" ) ) : ?>
                        <?php foreach( $relationTable::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("owner=:owner")->setParams(array("owner"=>$relationItem->id))->setOrderBy("name")->setLimit(-1)->setCache(0) ) as $relationSubItem ) : ?>
                            <div>&nbsp;--&nbsp;<input type="checkbox" <?= in_array( $relationSubItem->id, $listValue ) ? "checked=\"checked\"" : "" ?> name="<?= SiteHelper::getCamelCase( $form->tableName() )."[".$relation[1] ?>][]" value="<?= $relationSubItem->id ?>" id="item_<?= $relation[1] ?>_<?= $relationSubItem->id ?>" /><label for="item_<?= $relation[1] ?>_<?= $relationSubItem->id ?>"><?= $relationSubItem->name ?></label></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<br/>
<table align="center" class="editTable">
    <tr>
        <td>
            <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/console/catalog").$controller->params ?>';" value="Отмена" />&nbsp;
            <input type="submit" name="submit_update" value="Сохранить" />
        </td>
    </tr>
</table>

</form>
<br/>
<h2>Галлерея</h2>
<form action="<?= SiteHelper::createUrl("/console/catalog/update", array( "id"=>$form->id)).$controller->params ?>" method="post" enctype="multipart/form-data">
    <?php echo CHtml::errorSummary( $addGallery ); ?>
    <div id="gallery">
        <div class="overflowHidden">
        <?php foreach( $listImage as $image ) : ?>
            <div class="GItem">
                <img src="../<?= ImageHelper::getImage( $image->image, 2, $image )  ?>" width="200" /><br/><input type="text" name="image[<?= $image->id ?>]" value="<?= $image->name ?>" />
                <a href="<?= SiteHelper::createUrl("/console/catalog/edit", array( "id"=>$form->id, "action"=>"gal_del", "img_id"=>$image->id )).$controller->params ?>">удалить</a>
            </div>
        <?php endforeach; ?>
        </div>
        <div align="center" class="overflowHidden">
            <input type="button" name="image_add" value="Добавить картинку">&nbsp;
            <input type="submit" name="image_submit" value="Сохранить галлерею">
        </div>
        <div class="formAdd displayNone">
            <table>
                <tr>
                    <th>Название</th>
                    <td><?= CHtml::activeTextField( $addGallery, "name" ) ?></td>
                </tr>
                <tr>
                    <th>Файл</th>
                    <td><?= CHtml::activeFileField( $addGallery, "image" ) ?></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="button" name="add_cunsel" value="Отмена">&nbsp;
                        <input type="submit" name="submit_add_gallery" value="Добавить">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
<br/>
<script type="text/javascript">
    $("input[name=image_add]").click( function ()
    {
        openCloseForm();
    })

    $("input[name=add_cunsel]").click( function ()
    {
        openCloseForm();
    })

    function openCloseForm()
    {
        var form = $('.formAdd');
        if( form.css("display") == "none" )form.show(200);
                                      else form.hide(200);
    }
</script>
