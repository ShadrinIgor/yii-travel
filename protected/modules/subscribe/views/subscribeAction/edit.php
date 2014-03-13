<div id="Address">
    <a href="<?= SiteHelper::createUrl( "/console" ) ?>">главная</a> ... <a href="<?= SiteHelper::createUrl( "/console/subscribe", $arrayParams ) ?>">назад к списку</a>
</div>
<h1>Редактирование - <?= $form->name ?></h1>
<form action="<?= SiteHelper::createUrl("/console/subscribe/update", array_merge( $arrayParams, array( "id"=>$form->id ) )) ?>" method="post" onsubmit="submitForm();"  enctype="multipart/form-data">
<?php
    echo CHtml::errorSummary($form);
    if( !empty( $message ) ):?><div class="messageSummary"><?= $message ?></div><?php endif;?>

<table align="center" class="editTable">
    <?= CCModelHelper::addForm( $form ); ?>
    <tr>
        <td colspan="2" class="textAlignCenter">
            <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/console/subscribe", $arrayParams) ?>';" value="Отмена" />&nbsp;
            <input type="submit" name="submit_update" value="Сохранить" />
        </td>
    </tr>
</table>

</form>

