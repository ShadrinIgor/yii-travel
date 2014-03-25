<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => "Описание отеля",
       "h1Titile" => "Описание отеля",
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
       "listGallery" => $listGallery,
       "sitePage" => '<a href="'.SiteHelper::createUrl( "/hotels/description" ).'/'.$item->slug.'.html" title="">просмотреть страницу отеля</a>'
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>