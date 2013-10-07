<?php

class UserHelper
{
    static public function getAmount( CatalogUsers $user = null )
    {
        if( empty( $user ) )$user = CatalogUsers::fetch( Yii::app()->user->id );

        $amount = $user->amount;
        if( empty( $amount ) )$amount = 0;
        return $amount;
    }
}