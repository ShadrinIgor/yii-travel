<?php

class DefaultController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->page->title = "Каталог продукции";

        $cid = (int)Yii::app()->request->getParam("cid", 0);

        if( !empty( $cid ) )
        {
            $items = CatalogMarkets::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "id in ( SELECT leftId FROM cat_relations WHERE rightId=:rightID AND leftClass=:leftClass AND rightClass=:rightClass )" )->setParams(array(":rightID"=>$cid, ":leftClass"=>"CatalogMarkets", ":rightClass"=>"CatalogMarketsCategory"))->setLimit(10)->setCache(0) );
            $category = CatalogMarketsCategory::fetch( $cid );
        }
        else
        {

            $items = CatalogMarkets::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(10)->setCache(0) );
            $category = CatalogMarketsCategory::fetch( 1 );
        }

/*
        if( !empty( $_POST["find"] ) )
        {
            // Надо определить параметры основные и дополнительные
            // затем исполльзую SQL запросом найти все записи из таблицы CatalogMarkets

            $categoryId = $_POST["CatalogMarkets"]["category_id"] >0 ? (int)$_POST["CatalogMarkets"]["category_id"] : 1;
            $categoryModel = CatalogMarketsCategory::fetch( $categoryId );
            $paramsTable = SiteHelper::getCamelCase( $categoryModel->table_name );
            $paramsModel = new $paramsTable();
            $itemFieldTypes = CatalogMarkets::fieldType();
            $paramsFieldTypes = $paramsModel->fieldType();

            $sql="SELECT i.* FROM catalog_items i, ".$paramsModel->tableName()." p WHERE i.id = p.item_id ";

            // Проверяем основные параметры
            foreach( CatalogMarkets::attributeLabels() as $key=>$value )
            {
                if( !empty( $_POST["CatalogMarkets"][ $key ] ) || !empty( $_POST["CatalogMarkets"][ $key."_2" ] ) )
                {
                    $value = !empty( $_POST[ "CatalogMarkets" ][ $key ] ) ? str_replace("'", "", $_POST[ "CatalogMarkets" ][ $key ]) : "";
                    $value_2 = !empty( $_POST[ "CatalogMarkets" ][ $key."_2"] ) ? str_replace("'", "", $_POST[ "CatalogMarkets" ][ $key."_2" ]) : "";

                    if( !empty( $sql ) )$sql.=" AND ";
                    if( !empty( $itemFieldTypes[ $key ] ) && $itemFieldTypes[ $key ] == "integer" )
                    {
                        $sql .= " ( ";
                        if( !empty( $value ) )$sql .= " i.`".$key."`>='".$value."' ";
                        if( !empty( $value_2 ) )
                        {
                            if( !empty( $value ) ) $sql .= " AND ";
                            $sql .= " i.`".$key."`<'".$value_2."' ";
                        }
                        $sql .= " ) ";
                    }
                    else $sql .= " i.`".$key."`='".$value."' ";
                }
            }

            // Проверяем дополнительные параметры
            foreach( $paramsModel->attributeLabels() as $key=>$value )
            {
                if( !empty( $_POST[ $paramsTable ][ $key ] ) )
                {
                    $value = !empty( $_POST[ $paramsTable ][ $key ] ) ? str_replace("'", "", $_POST[ $paramsTable ][ $key ]) : "";
                    $value_2 = !empty( $_POST[ $paramsTable ][ $key."_2"] ) ? str_replace("'", "", $_POST[ $paramsTable ][ $key."_2" ]) : "";

                    if( !empty( $sql ) )$sql.=" AND ";

                    if( !empty( $paramsFieldTypes[ $key ] ) && $paramsFieldTypes[ $key ] == "integer" )
                    {
                        $sql .= " ( ";
                        if( !empty( $value ) )$sql .= " p.`".$key."`>='".$value."' ";
                        if( !empty( $value_2 ) )
                        {
                            if( !empty( $value ) ) $sql .= " AND ";
                            $sql .= " p.`".$key."`<'".$value_2."' ";
                        }
                        $sql .= " ) ";
                    }
                        else $sql .= " p.`".$key."`='".$value."' ";
                }
            }

            $result = CatalogMarkets::sql( $sql );
            $items = array();
            for( $i=0;$i<sizeof( $result );$i++ )
            {
                if( $result[$i]["id"] == 0 )continue;
                $newObject = new CatalogMarkets();
                $items[] = $newObject->setAttributesFromArray( $result[$i] );
            }
        }
*/
        $this->render( "index", array( "items" =>$items, "category"=>$category  ) );
	}

    public function actionGetUserInfo( )
    {
        $id = (int)Yii::app()->request->getParam("id",0);
        $field = Yii::app()->request->getParam("field","");
        if( $id>0 && !empty( $field ) )
        {
            $userModel = CatalogUsers::fetch( $id );
            if( $userModel->id > 0 && property_exists( $userModel, $field ) )
            {
                Yii::app()->ih
                    ->load($_SERVER['DOCUMENT_ROOT'] . '/f/temp/1.jpg')
                    ->text( $userModel->$field, $_SERVER['DOCUMENT_ROOT'] . '/themes/classic/font/georgia.ttf',
                        11, array(2,95,160), CImageHandler::CORNER_LEFT_BOTTOM, 3, 3)
                    ->save($_SERVER['DOCUMENT_ROOT'] . '/f/temp/2.jpg');

                echo '<img src="/f/temp/2.jpg" />';
            }
        }
    }

    public function actionAjaxGetList()
    {
        $id = (int)Yii::app()->request->getParam("id",0);
        $catalog = Yii::app()->request->getParam("catalog","");
        $field = Yii::app()->request->getParam("field","");

        $cout = '<option value=""> --- --- --- </option>';
        if( $id>0 && !empty( $catalog ) && !empty( $field ) )
        {
            $catalogClass = SiteHelper::getCamelCase( $catalog );
            if( class_exists( $catalogClass ) )
            {
                $list = $catalogClass::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $field."=:id")->setParams( array( ":id"=>$id  ) )->setLimit( 300 )->setOrderBy("name") );
                foreach( $list as $item )
                {
                    $cout .= '<option value="'.$item->id.'">'.$item->name.'</option>';
                }
            }
        }

        echo $cout;
    }

    public function actionAjaxAddFormDopParam()
    {
        $cid_id = (int)Yii::app()->request->getParam("cid_id", 0);
        $id = (int)Yii::app()->request->getParam("id", 0);

        $cout = "";
        if( $cid_id>0  )
        {
            $categoryModel = CatalogMarketsCategory::fetch( $cid_id );
            if( $categoryModel->id >0 )
            {
                if( $categoryModel->table_name )
                {
                    $catalogClass = SiteHelper::getCamelCase( $categoryModel->table_name );
                    if( class_exists( $catalogClass ) )
                    {
                        if( $id>0 )$model = $catalogClass::fetch( $id );

                        if( empty( $model ) || $model->id==0 )
                            $model = new $catalogClass;

                        echo CCModelHelper::addForm( $model );
                    }
                }
            }
        }

        echo $cout;
    }

}