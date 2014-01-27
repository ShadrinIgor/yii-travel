<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => "Отзыв/коментарий",
       "h1Titile" => "Отзыв/коментарий",
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>