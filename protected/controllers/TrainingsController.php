<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 13.05.14
 * Time: 23:42
 */

class TrainingsController extends Controller
{
    public function actionIndex()
    {
        $action = Yii::app()->request->getParam("action", "");
        if( !empty( $action ) )
        {
            if( $action == "close" )TrainingsHelper::sessionClose();
        }
    }

    public function actionSave()
    {
        TrainingsHelper::actionSave();
    }

    public function actionBefore()
    {
        TrainingsHelper::getBeforeStep();
    }
}