<div id="innerPage">
<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
                    "Мои вакансии"=>SiteHelper::createUrl( "/user/work" ),
                    "Описание"
                  ),
));
?>
<h1>Описание Вакансии</h1>
<?php echo CHtml::errorSummary($item); ?><br>
<?php if( !empty( $message ) ) : ?>
    <div class="messageSummary"><?= $message ?></div>
<?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
    <table class="tableForm">
        <?=
            CatalogCCmodelHelper::addForm( $item )
        ?>
        <tr>
            <td></td>
            <td>
                <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/user/work") ?>';" name="update" value="Отмена" />&nbsp;
                <input type="submit" name="update" value="Сохранить" />
            </td>
        </tr>
    </table>
    </form>
</div>

