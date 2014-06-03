<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => Yii::t("user", "Отзыв/коментарий"),
       "h1Titile" => Yii::t("user", "Отзыв/коментарий"),
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>