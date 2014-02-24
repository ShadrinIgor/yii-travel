<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class authWidget extends CWidget
{
    public function run()
    {
        if( Yii::app()->user->isGuest )
        {
            Yii::import('modules.user.models.*');
            $form = new CatalogUsersAuth();
            $this->render( "auth", array( "form"=>$form ));
        }
            else
                $this->render( "auth_cabinet" );
    }
}
