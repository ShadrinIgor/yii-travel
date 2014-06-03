<?php

class DesktopController extends Controller
{
    public function actionIndex()
    {
        if( !Yii::app()->user->isGuest )
        {
            $message = "";
            Yii::app()->page->title = Yii::t("user", "Рабочий стол" );

            $userModel = CatalogUsers::fetch( Yii::app()->user->id );
            if( !empty( $_POST["desktop_save"] ) )
            {
                $desktopID = (int)Yii::app()->request->getParam("desktopID", 0);
                $userModel->desktop = $desktopID;
                $userModel->save();
                $userModel->formMessage = Yii::t("user", "Рабочий стол успешно сохранен" );
            }

            $items = CatalogDesktops::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0) );
            $this->render( "index", array( "message"=>$message, "items"=>$items, "userModel" =>$userModel ) );
        }
    }
}
