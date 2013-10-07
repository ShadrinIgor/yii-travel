<?php echo CHtml::form(); ?>
<?php echo CHtml::errorSummary($form); ?><br>

<table border="0" width="400" cellpadding="10" cellspacing="10">
    <tr>
        <td width="150"><?php echo CHtml::activeLabel($form, 'login'); ?></td>
        <td><?php echo CHtml::activeTextField($form, 'login') ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($form, 'passwd'); ?></td>
        <td><?php echo CHtml::activePasswordField($form, 'passwd') ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($form, 'passwd2'); ?></td>
        <td><?php echo CHtml::activePasswordField($form, 'passwd2') ?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::submitButton('Войти'); ?></td>
    </tr>
</table>
<?php echo CHtml::endForm(); ?>