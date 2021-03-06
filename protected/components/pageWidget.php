<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class pageWidget extends CWidget
{
    var $offset = 15;
    var $template = "catalog_default";
    var $catalog;
    var $title;
    var $description;
    var $category_id;
    var $keyWord;
    var $sectionTextSlug;
    var $url = 'tours';
    var $order = "id DESC";
    var $sort = array();
    var $conditional = "";
    var $showFindForm = true;

    public function __construct()
    {
        if( sizeof( $this->sort ) ==0 )
        {
            $this->sort = array(
                    array( "col",  Yii::t( "page", "просмотрам" ) ),
                    array( "name", Yii::t( "page", "названию" ) )
                );
        }

    }

    public function run()
    {
        $page = (int)Yii::app()->request->getParam("p", "1");
        $catalog = SiteHelper::getCamelCase( $this->catalog );

        $sortField = Yii::app()->request->getParam("sort", "");
        $by = Yii::app()->request->getParam("by", "");
        $status = Yii::app()->request->getParam("status", "");
        $params = Yii::app()->request->getParam("params", "");

        //if( ( $page!=1 || !empty( $sortField ) || !empty( $params ) ) || ( $page==1 && $this->beginCache( 'pageWidget_'.$catalog.'_1', array('duration'=>3600) ) ) ) :

            // Дополнение к TITLE
            $dopTitle = "";

            if( Yii::app()->getLanguage() != "ru" )
            {
                if( @class_exists( $catalog.ucfirst( Yii::app()->getLanguage() ) ) )
                    $catalog .= SiteHelper::getCamelCase( Yii::app()->getLanguage() );
            }

            // Очищаем параметры сессии
            // Если указан параметр черезе GET и это не сортировка и не страницы, от очищаем параметры
            if( $params == "empty" || ( !empty( $_GET ) && empty($_GET["sort"]) && empty($_GET["p"]) && empty($status) ) )Yii::app()->session[ "page_".$catalog ] = null;

            // Здесь будем хранить параметры сортировки и посика, для сохранения  в сессию
            $pageParams = array();

            if( empty( $sortField ) )
            {
                // Проверяем сохранено ли в сессии значение для сортироваки,
                // если нет, то выставляем значения по умолчанию
                if( !empty( Yii::app()->session[ "page_".$catalog ]["sort"] ) )
                {
                    $sortField = Yii::app()->session[ "page_".$catalog ]["sort"]["field"];
                    $by = Yii::app()->session[ "page_".$catalog ]["sort"]["by"];
                }
            }

            // Сортировка
            $SQLsort = $this->order;
            if( !empty( $sortField ) && property_exists( $catalog, $sortField ) )
            {
                if( $by == "desc" )$SQLsort = $sortField." DESC";
                              else $SQLsort = $sortField;

                // Сохряняем параметры сортировки для сессии
                $pageParams["sort"] = array( "field"=>$sortField, "by"=>$by );
            }

            $catalogModel = new $catalog();
            $SearchAttributes = $catalogModel->getSearchAttributes();
            $fieldsType = $catalogModel->fieldType();

            // Переменная будет хронить если человек ищет какой-то текст, и этот текст будет подсвечиватся
            $findText = "";

            // Поиск
            $SQL = " active=1 ";
            if( $this->conditional )$SQL = " active=1 AND ".$this->conditional;
            if( $status == "newYear" )
            {
                $SQL .= " AND is_newyear=1 ";
                $this->title = "Новогодние ".strtolower( $this->title );
            }

            $category = Yii::app()->request->getParam("category", "");
            if( !empty( $category ) )
            {
                $categoryClass = SiteHelper::getCamelCase( $this->$catalog."_category" );
                $categoryModel = $categoryClass::fetchByKeyWord( $category );
                if( $categoryModel->id >0 )$SQL.=" AND category_id='".$categoryModel->id."'";
            }
            $country = Yii::app()->request->getParam("country", "");

            if( !empty( $SearchAttributes ) && is_array($SearchAttributes) && sizeof($SearchAttributes)>0)
            {
                $arrayFindParam = array();
                foreach( $SearchAttributes as $field ) :

                    $field = trim( $field );
                    $fieldValue_2 = "";
                    $fieldValue = Yii::app()->request->getParam( $field, "" );
                    if( empty($fieldValue) && !empty( $_POST[$catalog] ) && !empty( $_POST[$catalog][ $field ] ) )$fieldValue = $_POST[$catalog][ $field ];

                    // Если тип поля integer то проверяем поля ОТ и ДО
                    if( !empty( $fieldsType[ $field ] ) && $fieldsType[ $field ] == "integer" )
                    {
                        if( !empty( $_POST[$catalog] ) && !empty( $_POST[$catalog][ $field."_2" ] ) )$fieldValue_2 = $_POST[$catalog][ $field."_2" ];
                        else $fieldValue_2 = "";

                        $fieldValue = (int)$fieldValue;
                        $fieldValue_2 = (int)$fieldValue_2;
                    }

                    if( empty( $fieldValue ) && empty( $fieldValue_2 ) && !empty( Yii::app()->session[ "page_".$catalog ]["find"] ) )
                    {
                        if( !empty( Yii::app()->session[ "page_".$catalog ]["find"][$field] ) )$fieldValue = Yii::app()->session[ "page_".$catalog ]["find"][$field];
                        if( !empty( Yii::app()->session[ "page_".$catalog ]["find"][$field."_2"] ) )$fieldValue_2 = Yii::app()->session[ "page_".$catalog ]["find"][$field."_2"];
                    }

                    if( !empty( $fieldValue ) || !empty( $fieldValue_2 ) )
                    {
                        if( !empty( $fieldsType[ $field ] ) && $fieldsType[ $field ] == "integer" )
                        {
                            if( !empty( $fieldValue ) && $fieldValue>0 )$SQL .= " AND ".$field.">=".$fieldValue;
                            if( !empty( $fieldValue_2 ) && $fieldValue_2>0 )$SQL .= " AND ".$field."<".$fieldValue_2;
                        }
                            elseif( $relation = $catalogModel->getRelationByField( $field ) ) // Проверяем условие
                            {
                                $relationCatalog = $relation[1];
                                if( !empty( $relationCatalog ) )
                                {
                                    $relationItem = $relationCatalog::fetch( (int)$fieldValue );
                                    if( !empty( $relationItem ) && $relationItem->id >0 )
                                    {
                                        // Добавилям в titile
                                        if( !empty( $dopTitle ) )$dopTitle .= ", ";
                                        $dopTitle .= $relationItem->name;
                                    }
                                }
                                $SQL .= " AND `".$field."`='".$fieldValue."'";
                                $fieldValue_2 = 0;
                            }
                                else // Если остальные условия не сработали значит считаем что ищут текст
                                {
                                    $SQL .= " AND `".$field."` like '%".$fieldValue."%'";
                                    $fieldValue_2 = 0;
                                    $findText = $fieldValue;
                                }

                        $arrayFindParam[ $field ] = $fieldValue;
                        $arrayFindParam[ $field."_2" ] = $fieldValue_2 ;
                    }

                endforeach;

                // Сохряняем параметры каталога для сессии
                $pageParams["find"] = $arrayFindParam;
                $catalogModel->setAttributesFromArray( $arrayFindParam );

                // Сохраняем все в сессию
                Yii::app()->session[ "page_".$catalog ] = $pageParams;
            }

            $items = $this->render( $this->template,
                array(
                        'url'=> $this->url,
                        "items" => $catalog::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $SQL )->setOrderBy( $SQLsort )->setCache(0)->setPage( $page )->setLimit( $this->offset ) ),
                        'findText' => $findText
                ),
                true );

            if( !empty( $dopTitle ) )$dopTitle = $dopTitle." - ";

            // Выставляем TITLE для страницы
            Yii::app()->page->title = $dopTitle.$this->title;
            Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );

            $addUrl = "";
            $linkName = "";
            $findTitle = "Поиск";
            switch( $catalogModel->tableName() )
            {
                case "catalog_firms" :
                case "catalog_firms_en" :$addUrl =  SiteHelper::createUrl( "/user/firms/description/" );$linkName= Yii::t( "page", "Добавить тиристическое агенство");break;
                case "catalog_hotels" :
                case "catalog_hotels_en" :$addUrl =  SiteHelper::createUrl( "/user/hotels/description/" );$linkName=Yii::t( "page","Добавить отель/гостиницу");break;
                case "catalog_kurorts" :
                case "catalog_kurorts_en" : $addUrl =  SiteHelper::createUrl( "/user/resort/description/" );$linkName=Yii::t( "page","Добавить зону отдыха / курорт /дет. лагерь");break;
                case "catalog_firms_items" :
                case "catalog_firms_items_en" :$addUrl =  SiteHelper::createUrl( "/user/sales/description/" );$linkName=Yii::t( "page","Добавить АКЦИЮ / СКИДКУ");break;
                case "catalog_tours" : $findTitle = "ПОДОБРАТЬ ТУР";break;
            }

            $this->render( "page", array(
                'linkName'       => $linkName,
                'findTitle'      => $findTitle,
                'showFindForm'   => $this->showFindForm,
                'addUrl'         => $addUrl,
                'items'          => $items,
                'page'           => $page,
                'sectionTextSlug'=> $this->sectionTextSlug,
                'catalog'        => $catalog,
                'sort'           => $this->sort,
                'sortField'      => $sortField,
                'by'             => $by,
                'offset'         => $this->offset,
                'arrSearchFields'=> $SearchAttributes,
                'attributeLabels'=> $catalogModel->attributeLabels(),
                'tableModel'     => $catalogModel,
                'SQLParams'      => $SQL,
                'url'            => $this->url,
                'title'          => $dopTitle ? $dopTitle."<font>".$this->title."</font>" : $this->title,
            ));

        //    if( empty( $sortField ) && empty( $params ) && $page == 1 )$this->endCache();
        //endif;
    }
}
