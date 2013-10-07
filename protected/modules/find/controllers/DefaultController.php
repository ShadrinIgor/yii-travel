<?php

class DefaultController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $findText = Yii::app()->request->getPost("findText", "");
        if( !empty( $findText ) )$this->textFind( $findText );
            else $this->paramFind();
	}

    public function textFind( $findText )
    {
        Yii::app()->page->title = "Поиск продукции";
        if( !empty( $findText ) )
        {
            $arrayData = array();
            $listCid = CatalogItemsCategory::sql( "SELECT c2.name as cid_name, c.name, c.id, count(i.id) as c FROM catalog_items_category c, catalog_items_category c2, catalog_items i WHERE ( i.name like '%".$findText."%' OR i.description like '%".$findText."%' ) AND c.id=i.category_id AND c2.id = c.owner GROUP BY i.category_id" );

            for( $i=0;$i<sizeof( $listCid );$i++ )
            {
                $cidName = $listCid[$i]["cid_name"];
                if( !empty( $arrayData[$cidName]["count"] ) )
                    $arrayData[$cidName]["count"] += $listCid[$i]["c"];
                else
                    $arrayData[$cidName]["count"] = $listCid[$i]["c"];

                $arrayData[$cidName]["items"][] = $listCid[$i];
            }

            $items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "name like '%".$findText."%' OR description like '%".$findText."%'" )->setLimit(10) );
            $this->render( "index", array( "arrayData"=>$arrayData, "items" =>$items ) );
        }
            else $this->redirect( SiteHelper::createUrl("/") );
    }

    public function paramFind()
    {
        // Надо определить параметры основные и дополнительные
        // затем исполльзую SQL запросом найти все записи из таблицы CatalogItems
        $paramsTable = $_POST["paramsTable"];
        $paramsTable = str_replace("'", "", $paramsTable);
        //$paramsTable = mysql_real_escape_string( $paramsTable );
        $paramsModel = new $paramsTable();

        $sql="SELECT i.* FROM catalog_items i, ".$paramsModel->tableName()." p WHERE i.id = p.item_id ";

        foreach( $_POST as $key=>$value )
        {
            if( !is_array( $value ) )
            {
                if( property_exists( "CatalogItems", $key  ) && !empty( $value ) )
                {
                    $value = str_replace("'", "", $value);
                    //$value = mysql_real_escape_string( $value );

                    if( !empty( $sql ) )$sql.=" AND ";
                    $sql .= " i.`".$key."`='".$value."' ";
                }
            }
                else
            {
                foreach( $value as $key2=>$value2 )
                {
                    if( property_exists( $paramsTable, $key2 ) && !empty( $value2 )  )
                    {
                        if( !empty( $sql ) )$sql.=" AND ";
                        $sql .= " p.`".$key2."`='".$value2."' ";
                    }
                }
            }
        }


        $items = CatalogItems::sql( $sql );
        $itemsModels = array();
        for( $i=0;$i<sizeof( $items );$i++ )
        {
            if( $items[$i]["id"] == 0 )continue;
            $newObject = new CatalogItems();
            $itemsModels[] = $newObject->setAttributesFromArray( $items[$i] );
        }

        $this->render( "params", array( "items"=>$itemsModels ) );
    }
}