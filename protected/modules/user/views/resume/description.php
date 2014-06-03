<?php
$this->widget( "userPagesWidget", array(
    "adressTitle" => Yii::t("user", "Описание резюме"),
    "h1Titile" => Yii::t("user", "Описание резюме"),
    "item" => $item,
    "message" => $message,
    "gallMessage" => $gallMessage,
    "listComments" => $listComments,
    "addImage" => $addImage,
    "comMessage" => $comMessage,
    "listGallery" => $listGallery,
    "sitePage" => ''
) );
?>
<?php $this->widget( "formNoteWidget" ) ?>