<div id="Address">
    <a href="<?= SiteHelper::createUrl( "/console" ) ?>">главная</a> ... <a href="<?= SiteHelper::createUrl( "/console/subscribe", $arrayParams ) ?>">назад к списку</a>
</div>
<h1>Статистика - <?= $item->name ?></h1>

<table align="center" class="editTable">
    <tr>
        <th>Надо отправить:</th>
        <td><?= $needSend ?></td>
    </tr>
    <tr>
        <th>Уже отпривленно:</th>
        <td><?= $countSend ?></td>
    </tr>
    <tr>
        <th>Просмотренно:</th>
        <td>~<?= $countOpen ?></td>
    </tr>

</table>

</form>

