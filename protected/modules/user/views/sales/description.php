<?php
   $this->widget( "userPagesWidget", array(
       "adressTitle" => Yii::t("user", "Описание акции"),
       "h1Titile" => Yii::t("user", "Описание акции"),
       "item" => $item,
       "message" => $message,
       "gallMessage" => $gallMessage,
       "listComments" => $listComments,
       "addImage" => $addImage,
       "comMessage" => $comMessage,
       "listGallery" => $listGallery,
       "sitePage" => '<a href="'.SiteHelper::createUrl( "/sales/description" ).'/'.$item->slug.'.html" title="'.Yii::t("user", "просмотреть страницу акции на сайте").'">'.Yii::t("user", "просмотреть страницу акции на сайте").'</a>'
   ) );
?>
<?php $this->widget( "formNoteWidget" ) ?>