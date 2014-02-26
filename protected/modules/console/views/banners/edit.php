<h1>Редактирование - <?= $form->message ?></h1>
<form action="<?= SiteHelper::createUrl("/console/banners/update", array( "id"=>$form->id))?>" method="post" onsubmit="submitForm()"  enctype="multipart/form-data">
<?php
    echo CHtml::errorSummary($form);
    if( !empty( $message ) ):?><div class="messageSummary"><?= $message ?></div><?php endif;?>
<br>

<table align="center" class="editTable">
    <?= CCModelHelper::addForm( $form ); ?>
    <tr>
        <td></td>
        <td>
            <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/console/banners") ?>';" value="Отмена" />&nbsp;
            <input type="submit" name="submit_update" value="Сохранить" />
        </td>
    </tr>
</table>
</form>
