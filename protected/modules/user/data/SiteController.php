<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionListCity()
	{
        $countryId = !empty( $_GET["country"] ) && (int) $_GET["country"] >0 ? (int) $_GET["country"] : null;

        if( !empty( $countryId ) )
        {
            $dbcriterii = DBQueryParamsClass::CreateParams()->
                    setConditions( "country=:country_id" )->
                    setParams( array( ":country_id"=>$countryId ) );

            $cout = "";
            $listCity = CatalogCity::fetchAll( $dbcriterii );
            if( sizeof( $listCity )>0 )
            {
                foreach( $listCity as $key=>$data )
                    $cout .= "<option value='".$data->id."'>".$data->name."</option> ";
            }
                else $cout .= "<option value=''> --- --- --- </option> ";
            echo $cout;
        }
        Yii::app()->end();
        die;
	}

}