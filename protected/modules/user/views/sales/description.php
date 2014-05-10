<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => "Описание акции",
       "h1Titile" => "Описание акции",
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
       "listGallery" => $listGallery,
       "sitePage" => '<a href="'.SiteHelper::createUrl( "/sales/description" ).'/'.$item->slug.'.html" title="">просмотреть страницу акции на сайте</a>'
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>