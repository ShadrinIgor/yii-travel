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
</table>

    <h2>Адресаты</h2>

<table align="center" class="editTable">
    <tr>
        <th>Все пользователи:</th>
        <td><input type="radio" name="SubscribeItems[users]" <?= $form->users == 1 ? "checked" : "" ?> value="1" /> - <?= CatalogUsers::count( DBQueryParamsClass::CreateParams()->setLimit(-1) ) + SubscribeUsers::count( DBQueryParamsClass::CreateParams()->setLimit(-1) ) ?></td>
    </tr>
    <tr>
        <th>Зерегестрированные пользователи:</th>
        <td><input type="radio" name="SubscribeItems[users]" <?= $form->users == 2 ? "checked" : "" ?>  value="2" /> - <?= CatalogUsers::count( DBQueryParamsClass::CreateParams()->setLimit(-1) ) ?></td>
    </tr>
    <tr>
        <th>Потенциальные пользователи:</th>
        <td><input type="radio" name="SubscribeItems[users]" <?= $form->users == 3 ? "checked" : "" ?>  value="3" /> - <?= SubscribeUsers::count( DBQueryParamsClass::CreateParams()->setLimit(-1) ) ?></td>
    </tr>
    <tr>
        <th>Определенные адрессаты:</th>
        <td>
            <input type="radio" name="SubscribeItems[users]" <?= $form->users == 4 ? "checked" : "" ?>  value="4" /><br/>
            <?= Chtml::activeTextArea( $form, "users_list" ) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="textAlignCenter">
            <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/console/subscribe", $arrayParams) ?>';" value="Отмена" />&nbsp;
            <input type="submit" name="submit_update" value="Сохранить" />
        </td>
    </tr>
</table>

</form>

