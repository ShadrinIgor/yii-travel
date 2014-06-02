<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        Yii::t("page", "Отписка от рассылки")
    )
));
?>

<h1><?= Yii::t("page", "Отписка от рассылки"); ?></h1>
<center>
    <?= Yii::t("page", "Ваш Email успешно отключен от рассылки."); ?>
</center>
<?php $this->widget( "formNoteWidget", array( "type"=>"infoErrorNote" ) ); ?>