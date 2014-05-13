<?php

class TrainingsHelper
{
    public static function run()
    {
        $userModel = CatalogUsers::fetch( Yii::app()->user->getId() );
        if( $userModel->id >0 )
        {
            // Надотпроверять какие данные пользователь уже ввел чтобы выдавать ему то чего он еще не ввел
            // 1. Типо пользователя ( если он не добавил ни фирму ни отель ни курорт )
            //      надо сделать так чтобы при добавлении отеля тур фирмы курорта пользователю выставлялось занчение поля trainings = 1 ( т.е. не выдавать ему заново выберите тип )

            if( $userModel->trainings == 0 )
            {
                $trainingModel = CatalogTraining::findByAttributes( array( "step"=>1 ) );
                if( sizeof( $trainingModel ) > 0 )
                {
                    $method = $trainingModel[0]->method;
                    TrainingsHelper::$method();
                }
            }

            // Проверяем небыла ли открыта ссесия ранее
            $checkModel = CatalogTrainingSession::findByAttributes( array( "training_id"=>$trainingModel[0]->id ) );
            if( sizeof( $checkModel ) == 0 )
            {
                // Если нет то открываем её
                $newSession = new CatalogTrainingSession();
                $newSession->user_id = Yii::app()->user->getId();
                $newSession->training_id = $trainingModel[0]->id;
                $newSession->date = time();
                if( !$newSession->save() )
                    print_r( $newSession->getErrors() );
            }
        }
    }

    public static function firstStep()
    {
        Yii::app()->controller->widget( "trainingsWidget", array( "template"=>"trainings_firstStep" ) );
    }
}