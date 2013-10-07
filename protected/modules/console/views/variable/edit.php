<h1>Редактирование - <?= $form->message ?></h1>
<form action="<?= SiteHelper::createUrl("/console/variable/update", array( "id"=>$form->id))?>" method="post" onsubmit="submitForm()"  enctype="multipart/form-data">
<?php
    echo CHtml::errorSummary($form);
    if( !empty( $message ) ):?><div class="messageSummary"><?= $message ?></div><?php endif;?>
<br>

<table align="center" class="editTable">
    <?= CCmodelHelper::addForm( $form ); ?>
    <tr>
        <td></td>
        <td>
            <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/console/variable") ?>';" value="Отмена" />&nbsp;
            <input type="submit" name="submit_update" value="Сохранить" />
        </td>
    </tr>
</table>
</form>
<?php if( $form->id >0 ) : ?>
    <br/>
    <table align="center" >
        <tr>
            <th>Language</th>
            <th>Message</th>
        </tr>
        <tr>
            <td><?= $translate->language ?></td>
            <td><?= $translate->translation ?></td>
        </tr>
    </table>
<?php endif; ?>