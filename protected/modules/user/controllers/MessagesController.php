<?php

class MessagesController extends UserController
{
    var $firmId;

    public function init()
    {
        parent::init();
        $this->addModel = "Notifications";
        $this->tableName = "Notifications";
        $this->name = Yii::t("user", "Сообщения");

        $this->firmId = (int) Yii::app()->request->getParam("fid", 0);
        $id = (int) Yii::app()->request->getParam("id", 0);
        $return = false;
    }

    public function actionDescription( $gallError = "" )
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title =  Yii::t("page", "Описание");

            $id = (int)Yii::app()->request->getParam("id", 0);
            $addClass = $this->addModel;

            if( !empty( $id ) )
            {
                $item = $addClass::fetch( $id );
                $item->is_new = 0;
                $item->save();
            }
                     else $item = new $addClass();

                $this->render( "description", array( "item"=>$item) );
        }
    }
}
