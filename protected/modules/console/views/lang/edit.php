<h1>Редактирование - <?= $form->name ?></h1>
<form action="<?= SiteHelper::createUrl("/console/lang/update", array( "id"=>$form->id))?>" method="post" onsubmit="submitForm()"  enctype="multipart/form-data">
<?php
    echo CHtml::errorSummary($form);
    if( !empty( $message ) ):?><div class="messageSummary"><?= $message ?></div><?php endif;?>
<br>

<table align="center" class="editTable">
    <?= CCModelHelper::addForm( $form ); ?>
    <tr>
        <td></td>
        <td>
            <input type="button" onclick="window.location = '<?= SiteHelper::createUrl("/console/lang") ?>';" value="Отмена" />&nbsp;
            <input type="submit" name="submit_update" value="Сохранить" />
        </td>
    </tr>
</table>
</form>

<form action="<?= SiteHelper::createUrl("/console/lang/edit", array( "id"=>$form->id )) ?>" method="post">
<h1>Языковые пременные</h1>
<table id="tableListItems">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Language</th>
    </tr>
    <?php
        $i=0;
        foreach( $list as $item ) : ?>
        <tr>
            <td><?= $item->id ?></td>
            <td>
                <textarea rows="2" cols="80" name="trans[<?= $i ?>][translation]" class="mceNoEditor"><?= $item->translation ?></textarea>
                <input type="hidden" name="trans[<?= $i ?>][id]" value="<?= $item->id ?>" />
            </td>
            <td align="center">
                <select name="trans[<?= $i ?>][language]">
                    <?php foreach( $lang as $litem ) : ?>
                        <option value="<?= $litem->slug ?>" <?= ( $litem->slug == $item->language ? "selected" : "" ) ?>><?= $litem->slug ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    <?php $i++;endforeach; ?>
    <?php if( sizeof( $list ) != sizeof($lang) ) : ?>
        <?php for( $n=0;$n< ( sizeof($lang) - sizeof( $list ) );$n++  ) : ?>
            <tr>
                <td></td>
                <td>
                    <textarea rows="2" cols="80" name="trans[<?= $i ?>][translation]" class="mceNoEditor"></textarea>
                    <input type="hidden" name="trans[<?= $i ?>][id]" value="" />
                </td>
                <td align="center">
                    <select name="trans[<?= $i ?>][language]">
                        <?php foreach( $lang as $litem ) : ?>
                            <option value="<?= $litem->slug ?>"><?= $litem->slug ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        <?php $i++;endfor; ?>
    <?php endif; ?>
</table>
<center>
    <input type="submit" value="Сохранить" name="transSubmit" /></a>
</center>
</form>