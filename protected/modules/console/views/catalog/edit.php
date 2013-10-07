<h1>Редактирование - <?= $form->name ?></h1>
<form action="<?= SiteHelper::createUrl("/console/catalog/update", array( "id"=>$form->id)).$controller->params?>" method="post" onsubmit="submitForm()"  enctype="multipart/form-data">
<?php
    echo CHtml::errorSummary($form);
    if( !empty( $message ) ):?><div class="messageSummary"><?= $message ?></div><?php endif;?>
<br>

<table align="center" class="editTable">
    <?= CCmodelHelper::addForm( $form ); ?>
    <tr>
        <td></td>
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
