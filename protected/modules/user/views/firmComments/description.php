<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => Yii::t("user", "Отзыв/комментарий"),
       "h1Titile" => Yii::t("user", "Отзыв/комментарий"),
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>