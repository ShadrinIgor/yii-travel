<h1><?= $model->name ?></h1>

<form action="" method="post" enctype="multipart/form-data">
    <?= CHtml::errorSummary( $model ); ?>
    <?= $model->getMessage(); ?>
    <table id="tableListItems">
        <?= CCModelHelper::addForm( $model ) ?>
        <tr>
            <th>Получатели</th>
            <td>
                <a href="#" title="" id="userGroups">Отметить все</a>&nbsp;|&nbsp;<a href="#" title="" id="userGroups2">Снять все</a>
                <div>
                    <?php foreach( $users as $item ) : ?>
                        <div style="padding: 5px 10px;border-bottom: 1px solid #afafaf;margin-bottom: 5px;"><input type="checkbox" <?= in_array( $item->id, $relations ) ? "checked" : "" ?> name="SubscribeTable[SubscribeTableUsers][]" value="<?= $item->id ?>" id="item<?= $item->id ?>" /><label for="item<?= $item->id ?>"><?= $item->name ?></label></div>
                    <?php endforeach; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" name="button" onclick="window.location.href='<?= SiteHelper::createUrl("/console/subscribeTable") ?>'" value="Назад" />&nbsp;
                <input type="submit" name="submit" value="Отправить" />
            </td>
        </tr>
    </table>
</form>
<script style="text/javascript">
    $( document).ready( function()
    {
        $("#userGroups").click( function()
        {
            $( this).parent().find("input[type=checkbox]").attr( "checked", "checked" );
            return false;
        })

        $("#userGroups2").click( function()
        {
            $( this).parent().find("input[type=checkbox]").removeAttr( "checked" );
            return false;
        })
    })
</script>