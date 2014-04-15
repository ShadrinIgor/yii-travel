<?php

class users
{
    public $id;
    public $login;
    public $password;

    public function users( $id, $login, $password )
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
    }

    static function getUser( $id, $login, $password )
    {
        return new users( $id, $login, $password );
    }

    static function fromArray( array $value )
    {
        return new users( $value->id, $value->login, $value->password );
    }

    public function toArray()
    {
        return array( "id"=>$this->id, "login"=>$this->login, "password"=>$this->password );
    }
}
