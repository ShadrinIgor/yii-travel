<?php

class CatalogCCModel extends CCModel
{
    protected $param;

    static public function fetchParam( $id )
    {
        $nameCLass = get_called_class();

        $model = $nameCLass::fetch($id);

        if( $model->id >0 )
        {

            if( $model->category_id > 0 )
            {
                $categoryModel = CatalogItemsCategory::fetch( $model->category_id );

                if( $categoryModel->table_name )
                {
                    $categoryTable = SiteHelper::getCamelCase( $categoryModel->table_name );

                    $paramItem = $categoryTable::findByAttributes( array( "item_id"=>$model->id ) );
                    if( !empty( $paramItem[0] ) )$model->param = $paramItem[0];
                }
            }
        }
            else return false;

        return $model;
    }

    public function saveParam()
    {
        if( $this->saveWithRelation() )
        {
            if( $this->category_id > 0 )
            {
                $categoryModel = CatalogItemsCategory::fetch( $this->category_id );
                if( $categoryModel->table_name )
                {
                    if( $this->id >0 )
                    {  // Обновление записи
                        $categoryTable = SiteHelper::getCamelCase( $categoryModel->table_name );
                        $paramItemArray = $categoryTable::findByAttributes( array( "item_id"=>$this->id ) );

                        if( sizeof( $paramItemArray ) >0 && $paramItemArray[0]->id )
                        {
                            $paramItem = $paramItemArray[0];
                            if( !empty( $_POST[ $categoryTable ] ) )
                            {
                                $paramItem->setAttributesFromArray( $_POST[ $categoryTable ] );
                                if( !$paramItem->saveWithRelation() )
                                {
                                    $this->addErrors( $paramItem->getErrors() );
                                    return false;
                                }
                            }
                        }
                            else
                        {   // создание записи
                            $paramItem = new $categoryTable();
                            if( !empty( $_POST[ $categoryTable ] ) && sizeof( $_POST[ $categoryTable ] ) >0 )$paramItem->setAttributesFromArray( $_POST[ $categoryTable ] );
                            $paramItem->item_id = $this->id;
                            if( !$paramItem->saveWithRelation() )
                            {
                                $this->addErrors( $paramItem->getErrors() );
                                return false;
                            }
                        }
                    }
                }

                // Обновление параметров
                $this->refreshParam();
            }
        }
          else return false;

        return true;
    }

    public function refreshParam()
    {
        if( $this->category_id > 0 )
        {
            $categoryModel = CatalogItemsCategory::fetch( $this->category_id );
            if( $categoryModel->table_name )
            {
                $categoryTable = SiteHelper::getCamelCase( $categoryModel->table_name );
                $paramItem = $categoryTable::findByAttributes( array( "item_id"=>$this->id ) );
                if( sizeof($paramItem)>0 )$this->param = $paramItem[0];
                                     else $this->param = new $categoryTable();
            }
        }
    }

    public function getListProperty()
    {
        $list = array();
        $param = $this->param;
        $fieldTypes = $param->fieldType();

        foreach( $param->attributeLabels() as $key=>$value )
        {
            if( $param->$key )
            {
                if( is_object( $param->$key ) )$list[ $value ] = $param->$key->name;
                    else
                {
                    if( !empty( $fieldTypes[ $key ] ) )
                    {
                        switch( $fieldTypes[ $key ] )
                        {
                            case "checkbox" : $list[ $value ] = $param->$key ? "до" : "нет";break;
                            default : $list[ $value ] = $param->$key;break;
                        }
                    }
                        else $list[ $value ] = $param->$key;

                }
            }
        }

        return $list;
    }
}