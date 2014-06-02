<?php
$this->widget('addressLineWidget', array(
    'links'=>array( Yii::t("user", "Правила работы с сайтом" ) ),
));
?>
<h1><?= Yii::t("user", "Правила работы с сайтом" ) ?></h1>
<?= $text->description ?>