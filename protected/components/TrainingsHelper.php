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

            // Проверяем небыла ли открыта ссесия ранее
            $checkModel = CatalogTrainingSession::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "user_id=:user_id AND ( status_id=:status1 OR status_id=:status2 )" )->setParams( array( ":user_id"=>Yii::app()->user->getId(), ":status1"=>1, ":status2"=>2 ) )->setCache(-1) );
            if( sizeof( $checkModel ) == 0 )
            {

                //// Определеяем на каком шагу находится пользователь
                $chechSession = CatalogTraining::sql( "SELECT * FROM catalog_training WHERE `group` NOT IN ( SELECT `group` FROM catalog_training_session WHERE user_id='".Yii::app()->user->getId()."' ) ORDER BY `group` LIMIT 1 " );
                if( sizeof( $chechSession ) >0 )
                {
                    if( $chechSession[0]["condition"] )
                    {
                        $chechSession[0]["condition"] = str_replace( ":userId", Yii::app()->user->getId(), $chechSession[0]["condition"] );
                        $checkCondition = CatalogUsers::sql( $chechSession[0]["condition"] );
                        if( sizeof( $checkCondition ) == 0 )return;
                    }

                    // Если нет то открываем её
                    $newSession = new CatalogTrainingSession();
                    $newSession->user_id = Yii::app()->user->getId();
                    $newSession->training_id = $chechSession[0]["id"];
                    $newSession->group = $chechSession[0]["group"];
                    $newSession->status_id = 1;
                    $newSession->date = time();

                    if( !$newSession->save() )
                        print_r( $newSession->getErrors() );
                }
            }
                else
            {
                $checkModel[0]->status_id = 1;
                $checkModel[0]->save();
            }
        }
    }

    public static function show()
    {
        $userModel = CatalogUsers::fetch( Yii::app()->user->getId() );
        if( $userModel->id >0 )
        {
            // Проверяем небыла ли открыта ссесия
            $sessionModel = CatalogTrainingSession::findByAttributes( array( "user_id"=>Yii::app()->user->getId(), "status_id"=>1 ) );

            if( sizeof($sessionModel) >0 && $sessionModel[0]->id > 0 )
            {
                $method = $sessionModel[0]->training_id->method;

                echo '<div id="trainingForm">
                        <div id="TFInner">';

                TrainingsHelper::$method();

                echo '  </div>
                      </div>';
            }
        }
    }

    public static function actionSave()
    {
        if( !Yii::app()->user->isGuest )
        {
            /*
             *     [CatalogTrainings] => Array
                    (
                        [user_type] => 1
                    )
             */
            $session = CatalogTrainingSession::findByAttributes( array( "user_id"=>Yii::app()->user->getId() ) );
            if( $session[0]->id >0 )
            {
                $saveClassName = $session[0]->training_id->method."_save";
                TrainingsHelper::$saveClassName();
            }
        }
    }

    public static function sessionClose()
    {
        $session = CatalogTrainingSession::findByAttributes( array( "user_id"=>Yii::app()->user->getId() ) );
        if( $session[0]->id >0 )
        {
            $session[0]->status_id = 2;
            $session[0]->save();
            echo "close";
        }
    }

    public static function sessionFinish()
    {
        $session = CatalogTrainingSession::findByAttributes( array( "user_id"=>Yii::app()->user->getId() ) );
        if( $session[0]->id >0 )
        {
            $session[0]->status_id = 3;
            $session[0]->save();
            echo "close";
        }
    }

    public static function getBeforeStep()
    {
        $session = CatalogTrainingSession::findByAttributes( array( "user_id"=>Yii::app()->user->getId() ) );
        if( sizeof( $session ) >0 && $session[0]->id >0 && $session[0]->training_id->step >1 )
        {
            // Нужно определить есть ли предыдущие шагу у данной группы
            $groupName = $session[0]->training_id->group;
            $step = $session[0]->training_id->step - 1;
            $training = CatalogTraining::findByAttributes( array( "group"=>$groupName, "step"=>$step ) );
            if( sizeof( $training ) >0 )
            {
                $method = $training[0]->method;
                TrainingsHelper::$method();

                // Сохраняаем в сессию новый тренинг и исзменяем шанг
                $session[0]->training_id = $training[0]->id;
                $session[0]->save();
            }

        }
    }

    public static function stepFirst()
    {
        Yii::app()->controller->widget( "trainingsWidget", array( "template"=>"trainings_firstStep" ) );
    }

    public static function stepFirst_save()
    {
        $typeId = !empty( $_GET["CatalogTraining"] ) && !empty( $_GET["CatalogTraining"]["user_type"] ) ? (int) $_GET["CatalogTraining"]["user_type"] : 0;
        $listType = array( 1, 3, 4, 5 );
        $userModel = CatalogUsers::fetch( Yii::app()->user->getId() );
        if( $userModel->id >0 && $typeId >0 && in_array( $typeId, $listType ) )
        {
            // Сохраняем тип пользователя
            $userModel->type_id = $typeId;
            $userModel->trainings = 2;
            $userModel->save();

            // Определеяем следуюший шаг
            $nextTraining = CatalogTraining::findByAttributes( array( "step"=>2 ) );
            $nextTrainingMethod = $nextTraining[0]->method;

            // Увеличиваем шаг
            $session = CatalogTrainingSession::findByAttributes( array( "user_id"=>Yii::app()->user->getId() ) );
            $session[0]->step = 2;
            $session[0]->training_id = $nextTraining[0];
            $session[0]->save();

            // Выводит следующий шаг
            TrainingsHelper::$nextTrainingMethod();
        }

    }

    public static function step2()
    {
        $userModel = CatalogUsers::fetch( Yii::app()->user->getId() );
        Yii::app()->controller->widget( "trainingsWidget", array( "template"=>"trainings_2Step", "param"=>array( "type_id" => $userModel->type_id->id ) ) );
    }

}