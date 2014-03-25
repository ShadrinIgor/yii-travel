<?php
$this->widget( "userPagesWidget", array(
    "adressTitle" => "Мои зоны отдыха",
    "h1Titile" => "Описание зоны отдыха, курорта",
    "item" => $item,
    "message" => $message,
    "gallMessage" => $gallMessage,
    "listGallery" => $listGallery,
    "listComments" => $listComments,
    "addImage" => $addImage,
    "comMessage" => $comMessage,
    "sitePage" => '<a href="'.SiteHelper::createUrl( "/resorts/description" ).'/'.$item->slug.'.html" title="">просмотреть страницу зоны отдыха</a>'
) );
?>