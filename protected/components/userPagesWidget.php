<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class userPagesWidget extends CWidget
{
    var $adressTitle;
    var $h1Titile;
    var $item;
    var $message;
    var $gallMessage;
    var $listGallery;
    var $addImage;
    var $listComments;
    var $comMessage;

    public function run()
    {
        $this->render( "userPages", array(
                    "adressTitle" => $this->adressTitle,
                    "h1Titile" => $this->h1Titile,
                    "item" => $this->item,
                    "message" => $this->message,
                    "gallMessage" => $this->gallMessage,
                    "listGallery" => $this->listGallery,
                    "listComments" => $this->listComments,
                    "addImage" => $this->addImage,
                    "comMessage" => $this->comMessage,
                    "error" =>  Yii::app()->request->getParam("error", "" ),
            ));
    }
}
