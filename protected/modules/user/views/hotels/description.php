<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => Yii::t("user", "Описание отеля" ),
       "h1Titile" => Yii::t("user", "Описание отеля" ),
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
       "listGallery" => $listGallery,
       "sitePage" => '<a href="'.SiteHelper::createUrl( "/hotels/description" ).'/'.$item->slug.'.html" title="'.Yii::t("user", "просмотреть страницу отеля").'">'.Yii::t("user", "просмотреть страницу отеля").'</a>'
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>