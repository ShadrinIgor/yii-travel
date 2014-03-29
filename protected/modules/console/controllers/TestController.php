<?php

class TestController extends ConsoleController
{
    	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionCheckUsers()
	{
        $this->render( "index" );
        $res = CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("email!='' AND user_id=0")->setLimit( -1 )->setCache(0 ) );
        $i=0;
        foreach( $res as $item )
        {
            $email="";
            if( strpos( $item->email, "," ) )
                $item->email = trim( mb_substr( $item->email, 0, strpos( $item->email, "," ), "utf-8" ) );
            echo $item->id." | ".$item->name." - ".$item->email."<br/>";

            $findUser = CatalogUsers::findByAttributes( array( "email"=>$item->email ) );
            if( sizeof($findUser) == 0 )
            {
                echo "Create";
                $newUser = new CatalogUsers();
                $newUser->name = $item->name;
                $newUser->email = trim( $item->email );
                $newUser->image = $item->image;
                $newUser->pass = rand( 100, 999 );
                $newUser->password = md5( $newUser->pass );
                $newUser->active = 1;
                $newUser->country_id = $item->country_id->id;
                $newUser->type_id = 1;
                $newUser->site = $item->www;
                $newUser->phone = $item->tel;

                if( !$newUser->save() )print_r( $newUser->getErrors() );
            }
                else
                {
                    echo "Find - ".$findUser[0]->id;
                    $newUser = $findUser[0];
                }

            if( $newUser->id > 0 )
            {
                echo " save";
                $item->user_id = $newUser->id;
                $item->save();
            }
            echo "<br/>";
            $i++;
        }
	}
};