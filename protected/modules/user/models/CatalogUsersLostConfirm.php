<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsersLostConfirm extends CatalogUsers
{
    protected $password2; // string

 	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('password, password2', 'required'),
            array('password', 'compare', 'compareAttribute'=>'password2'),
            array('password', 'check_passwords'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('password', 'safe'),
		);
	}

    public function check_passwords($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $key = ( !empty( $_GET["key"] ) ) ? SiteHelper::checkedVaribal( $_GET["key"], "string" ) : "";
            $confirm = CatalogUsersConfirm::findByAttributes( array( "confirm_key"=>$key ) );
            if( !empty($confirm) && sizeof( $confirm )==1 )
            {
                $userModel = CatalogUsers::fetch( $confirm[0]->user_id->id );
                if( $userModel->active == 0 )$error = Yii::t("models", "Ваш аккаунт не активирован");
            }
                else $error = Yii::t("models", "Указан не верный ключ");

            if( !empty( $error ) )
            {
                $this->addErrors( array( "0"=>$error ) );
            }
                else $confirm[0]->delete();
        }
    }

}