<?php
$this->widget( "userPagesWidget", array(
    "adressTitle" => Yii::t("user", "Мои зоны отдыха"),
    "h1Titile" => Yii::t("user", "Описание зоны отдыха, курорта"),
    "item" => $item,
    "message" => $message,
    "gallMessage" => $gallMessage,
    "listGallery" => $listGallery,
    "listComments" => $listComments,
    "addImage" => $addImage,
    "comMessage" => $comMessage,
    "sitePage" => '<a href="'.SiteHelper::createUrl( "/resorts/description" ).'/'.$item->slug.'.html" title="'.Yii::t("user", "просмотреть страницу зоны отдыха" ).'">'.Yii::t("user", "просмотреть страницу зоны отдыха" ).'</a>'
) );
?>