<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersLost extends CatalogUsers
{
 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('email', 'required'),
            array('email', 'check_exists_params'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('email', 'safe'),
		);
	}

    public function check_exists_params($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $userList = CatalogUsers::findByAttributes( array( "email"=>$this->email ), 0 );

            if( !empty($userList) && sizeof( $userList )==1 )
            {
                // Если в базе уже сужествует запросы на востановление, до удаляем его
                $existConfirm = CatalogUsersConfirm::findByAttributes( array( "user_id"=>$userList[0]->id, "type"=>"lostpassword" ) );
                if( sizeof( $existConfirm )>0 )$existConfirm[0]->delete();

                if( $userList[0]->active == 0 )$error = Yii::t("models", "Ваш аккаунт не активирован");
            }
                else $error = Yii::t("models", "Вы ввели не существующий EMAIL" );

            if( !empty( $error ) )
            {
                $this->addErrors( array( "0"=>$error ) );
            }
        }
    }

}