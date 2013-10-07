<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public function authenticate()
    {
        $arrRecord=CatalogUsers::findByAttributes(array('email'=>$this->username), 0);
        if( !empty( $arrRecord ) && sizeof( $arrRecord )>0 )$record = $arrRecord[0];
            else $record = null;

        if($record===null)
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            $this->errorMessage = "Вы ввели не правельный логин или пароль";
        }
        else if($record->password!=md5($this->password))
        {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = "Вы ввели не правельный логин или пароль";
        }
            else
        {
            if( $record->active == 1 )
            {
                $this->_id=$record->id;
                $this->setState('title', $record->name);
                $this->errorCode=self::ERROR_NONE;
            }
                else
            {
                $this->errorMessage = "Ваш аккаунт не активен, обратитесь пожалуйста к администратору";
                $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
            }
        }

        return $this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}