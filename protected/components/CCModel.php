<?php
/**
 * User: Игорь
 * Date: 21.09.12
 * Надстройка на стандартный CModel, для более удобной работы с базой
 */
 class CCModel extends CModel
{
     const BELONGS_TO='CBelongsToRelation'; // связь между А и В один-ко-многим, значит В принадлежит А
     const HAS_ONE='CHasOneRelation';       // то частный случай HAS_MANY, где А может иметь максимум одно В
     const HAS_MANY='CHasManyRelation';     // связь между таблицами А и В один-ко-многим, значит у А есть много В
     const MANY_MANY='CManyManyRelation';   // эта связь соответствует типу связи многие-ко-многим в БД

     public $errors = array();
     public $isNewAdded;
     public $formMessage;

     function __construct()
     {
         SiteHelper::attacheHandlers( $this );
     }

     /*
     * @desc Вытаскивает из базы список значений по параметрам
     * @param DBQueryParamsClass $QueryParams
     * @param array $relationsTable Список связанных таблиц которые необходимо подгрузить сразу
     * @return array $arrayItemObject Возвращает массив объетов взятых из базе на основе переданных параметров
     * @return mixed $indexNumber По кокому принципу выставлять порядковые номера, по умолчанию INDEX выставляет от 0,1,2. Если указать ID то в качестве индексов будут выставленны ID записей
     */
     static function fetchAll( $QueryParams = null, array $relationsTable = array(), $indexNumber = "index" )
     {
         $nameCLass = get_called_class();
         $newObject = new $nameCLass;

         $tableAlias = self::getTableAlias( $newObject->tableName() );
         if( is_a( $QueryParams, "DBQueryParamsClass" )  )
         {
             if( empty( $QueryParams ) )$QueryParams = DBQueryParamsClass::CreateParams()->setConditions( $tableAlias.".del=0" );
                elseif( $QueryParams->getConditions()!="" ) $QueryParams->setConditions( $QueryParams->getConditions()." AND ".$tableAlias.".del=0 " );
                    else$QueryParams->setConditions( $tableAlias.".del=0 " );

             // Выставляем сортировку по умолчанию
             if( !$QueryParams->getOrderBy()  )$QueryParams->setOrderBy( $tableAlias.".id" );

             // Выставляем поля по умолчанию
             if( !$QueryParams->getFields() )$QueryParams->setFields( $tableAlias.".*" );

             // Определяем параметр WHERE
             if( $QueryParams->getWhere() )$dopWhere = $QueryParams->getWhere();
                                      else $dopWhere = $newObject->tableName()." as ".$tableAlias;

             // Определяем параметр WHERE
             if( $QueryParams->getFields() )$fields = $QueryParams->getFields();
                                       else $fields = "*";

             $arrayOffer = Yii::app()->db->cache( $QueryParams->getCache() )->createCommand()
                ->select( $fields )
                ->from( $dopWhere )
                ->where( $QueryParams->getConditions(), $QueryParams->getParams() )
                ->order( $QueryParams->getOrderBy() )
                ->limit( $QueryParams->getLimit() )
                ->offset( $QueryParams->getPage() )
                ->group( $QueryParams->getGroup() )
                ->queryAll();

/*             echo Yii::app()->db->cache( $QueryParams->getCache() )->createCommand()
                 ->select( $fields )
                 ->from( $dopWhere )
                 ->where( $QueryParams->getConditions(), $QueryParams->getParams() )
                 ->order( $QueryParams->getOrderBy() )
                 ->limit( $QueryParams->getLimit() )
                 ->offset( $QueryParams->getPage() )
                 ->group( $QueryParams->getGroup() )
                 ->getText();*/

         }
            elseif( is_a( $QueryParams, "CDbCriteria" )  )
             {
                 $builder = new \CDbCommandBuilder(\Yii::app()->db->getSchema());
                 $command = $builder->createFindCommand( $newObject->tableName(), $QueryParams);
                 $sql = $command->getText();

                 $arrayOffer = Yii::app()->db->createCommand( $sql )
                     ->queryAll();
             }
                 elseif( is_string( $QueryParams ) )
                 {
                     $arrayOffer = Yii::app()->db->cache( $QueryParams->getCache() )
                            ->createCommand( $QueryParams )
                            ->queryAll();
                 }
                    else
                    {
                        $arrayOffer = Yii::app()->db->cache( 1000 )->createCommand()
                            ->from( $newObject->tableName() )
                            ->where( "del=:del", array( ":del"=>0 ) )
                            ->order( "id" )
                            ->queryAll();
                    }

         if( !empty( $relationsTable ) )
         {
            foreach( $relationsTable as $relationTable )
            {
                $relationClass = str_replace(array(' ','_'), '', ucwords( preg_replace('/[^a-z]/', ' ', strtolower($relationTable)) ));
                $relationData = $newObject->getRelationByClass( $relationClass );
                if( !empty( $relationData ) && class_exists( $relationData[1] ) )
                {
                    $listRelationItems[ $relationData[1] ] =  $relationData[1]::fetchAll( DBQueryParamsClass::CreateParams()->setLimit("-1"), array(), "id");
                }
            }
         }

         $listOffer = array();
         for( $i=0;$i<sizeof( $arrayOffer );$i++ )
         {
            if( $arrayOffer[$i]["id"] == 0 )continue;
            $newObject = new $nameCLass;
            $newObject  = $newObject->setAttributesFromArray( $arrayOffer[$i] );

             // Подставляем связи если указан параметр $relationsTable ( работает только со связми ONE_TO_ONE )
             foreach( $relationsTable as $relationTable )
             {
                 $relationClass = str_replace(array(' ','_'), '', ucwords( preg_replace('/[^a-z]/', ' ', strtolower($relationTable)) ));
                 $relationData = $newObject->getRelationByClass( $relationClass );
                 if( !empty( $relationData ) )
                 {
                     $relationId = $arrayOffer[$i][ $relationData[2] ];
                     if( !empty($listRelationItems[ $relationData[1] ][ $relationId ]  ) )$newObject->$relationData[2] = $listRelationItems[ $relationData[1] ][ $relationId ];
                 }
             }

            if( $indexNumber == "id" )$listOffer[ $newObject->id  ] = $newObject;
                                 else $listOffer[ ] = $newObject;

         }

         return $listOffer;
     }

     static function findByAttributes( array $params, $cache = null )
    {
        $conditional = "";
        $param = array();
        foreach( $params as $key=>$value )
        {
            if( !empty( $conditional ) )$conditional.=" AND ";
            $conditional .= "`".$key."`=:".$key;
            $arrayKey = ":".$key;
            $param = array_merge( $param, array( $arrayKey=>$value ) );
        }

        $DBQueryParams = DBQueryParamsClass::CreateParams()
                        ->setConditions( $conditional )
                        ->setCache( $cache )
                        ->setLimit( -1 )
                        ->setParams( $params )
                        ->setOrderBy( "pos, name" );

        return self::fetchAll( $DBQueryParams );
    }

     public function delete( )
     {
         if( $this->id >0 )
         {

             $nameCLass = get_called_class();
             $newObject = new $nameCLass;

             // Удаялем физически картнки, привязанные к данной записи
             foreach( $this->fieldType() as  $field =>$type)
             {
                 if( $type == "image" && property_exists( get_class( $this ), $type) )
                 {
                    ImageHelper::deleteFile( $this, $field );
                 }
             }

             $count = Yii::app()->db->createCommand("DELETE FROM ".$newObject->tableName()." WHERE id='".$this->id."'")
                 ->execute();

             return $count>0 ? true : false;
         }
            else return false;
     }

     public function inBasket()
     {
         if( $this->id >0 )
         {
            Yii::app()->db->createCommand( "UPDATE ".$this->tableName()." SET del=1 WHERE id=".$this->id )->execute();
            return true;
         }
            else return false;

     }

     static function count( DBQueryParamsClass $QueryParams = null )
     {
         $nameCLass = get_called_class();
         $newObject = new $nameCLass;
         $tableAlias = self::getTableAlias( $newObject->tableName() );

         if( empty( $QueryParams ) )$QueryParams = DBQueryParamsClass::CreateParams()->setConditions( $tableAlias.".del=0" );
            elseif( $QueryParams->getConditions()!="" ) $QueryParams->setConditions( $QueryParams->getConditions()." AND ".$tableAlias.".del=0 " );
                else $QueryParams->setConditions( $tableAlias.".del=0 " );

         // Определяем параметр WHERE
         if( $QueryParams->getWhere() )$dopWhere = $QueryParams->getWhere();
                                  else $dopWhere = $newObject->tableName()." as ".$tableAlias;

         $count = Yii::app()->db->cache( $QueryParams->getCache() )->createCommand()
             ->select( "count(".$tableAlias.".id)" )
             ->from( $dopWhere )
             ->where( $QueryParams->getConditions(), $QueryParams->getParams() )
             ->order( $QueryParams->getOrderBy() )
//             ->limit( $QueryParams->getLimit() )
//             ->offset( $QueryParams->getPage() )
             ->queryScalar();

         return $count>0 ? $count : 0;
     }

     /*
     * @desc Вытаскивает из базы значение по ID
     * @param int $itemID Идентификатор записи в базе
     * @return object $itemObect объет созданный на основе давнных полученных с базы
     */
     static function fetchByKeyWord( $keyWord )
     {
         $nameCLass = get_called_class();
         $object =  new $nameCLass;
         if( !empty( $keyWord ) )
         {
             $offer = Yii::app()->db->createCommand()
                 ->select('*')
                 ->from( $object->tableName() )
                 ->where( 'key_word=:key_word AND del=0', array( ":key_word" => $keyWord ) )
                 ->queryRow();

             if( is_array( $offer ) )$object->setAttributesFromArray( $offer );
             else return false;
         }
         return $object;
     }

    /*
    * @desc Вытаскивает из базы значение по ID
    * @param int $itemID Идентификатор записи в базе
    * @return object $itemObect объет созданный на основе давнных полученных с базы
    */
    static function fetch( $id=0 )
    {
        $nameCLass = get_called_class();
        $object =  new $nameCLass;
        if( (int)$id>0 )
        {
            $offer = Yii::app()->db->createCommand()
                ->select('*')
                ->from( $object->tableName() )
                ->where( 'id=:id AND del=0', array( "id" => (int)$id ) )
                ->queryRow();



            if( is_array( $offer ) )$object->setAttributesFromArray( $offer );
                else return $object;
        }
        return $object;
    }

     static function sql( $sql )
     {
         $nameCLass = get_called_class();
         $object =  new $nameCLass;
         if( !empty( $sql ) )
         {
             $offer = Yii::app()->db->createCommand( $sql )
                 ->queryAll();

         }
         return $offer;
     }

    /*
    * @desc Устанавливаем значение из масива
    * @param array $arrayValue Масив присваеваемых значений
    * @return object $this Возвращает текущий объект
    */
    public function setAttributesFromArray( array $values )
    {
        foreach( $values as $key=>$value )
        {
            if( property_exists( $this, $key ) )
            {
                if( !empty( $value ) )$this->$key = $value;
                                 else $this->$key = "";
            }
        }

        return $this;
    }

    /*
    * @desc Общий метод SET, а также подгрузка связе при обращении
    * @param string $field Название свойства
    * @return mixed $fieldValue Значение свойства
    */
    public function __get( $field )
    {
        static $arrayHasOneRelation;
        $fieldTypes = $this->fieldType();

        // проверям не указна ли в типе поля таблица для связи многи ко многим
        $fieldHaveRelation = false;
        if( in_array( $field, $this->getRelationFields() ) )$fieldHaveRelation = true;
        if( is_array( $this->getRelationByKey( $field ) ) )$fieldHaveRelation = true;

        if( !$fieldHaveRelation )
        {
            if( property_exists( $this, $field ) )return $this->$field;
                                             else return "";
        }
        $relation = $this->getRelationByField( $field );
        if( empty( $relation ) )$relation = $this->getRelationByKey( $field );
        if( empty( $relation ) )
        {
            if( !empty( $fieldTypes[ $field ] ) && class_exists( $fieldTypes[ $field ] ) )
            {
                $relation = $this->getRelationByClass( $fieldTypes[ $field ] );
            }
        }

        if( !empty( $relation ) )
        {
            if( $this->$field ) // Выдаем объект только если поле не пусто
            {
                if( ( $relation[0] == self::HAS_ONE || $relation[0] == self::BELONGS_TO ) && !is_object( $this->$field ) ) //
                {
                    $key = $relation[1]."_".$field."_".$this->$field;
                    if( empty( $arrayHasOneRelation[ $key ] ) )
                    {
                        $this->$field = $relation[1]::fetch( $this->$field );
                        $arrayHasOneRelation[ $key ] = $this->$field;
                    }
                        else
                            $this->$field = $arrayHasOneRelation[ $key ];
                }
            }

            if( ( $relation[0] == self::HAS_MANY || $relation[0] == self::MANY_MANY ) && !is_array( $this->$field ) )
            {
                if( $relation[0] == self::HAS_MANY ) // Один ко многим
                {
                    $this->$field = $relation[1]::fetchAll
                                    (
                                        DBQueryParamsClass::CreateParams()
                                            ->setConditions( $relation[2]."=:field_value" )
                                            ->setParams( array( ":field_value"=>$this->id ) )
                                            ->setOrderBy("id")
                                    );

                }
/*                    else
                {  // ManyToMany не отработываем потому что, поле для связи и с левой и справой стороны идет ID, а его заполнять масивом нельзя
                    if(  )
                    $leftCLass = get_called_class();
                    $relationParams = RelationParamsClass::CreateParams()
                        ->setLeftClass( $leftCLass )
                        ->setRightClass( $relation[1] )
                        ->setLeftField( $field )
                        ->setLeftId( $this->id );

                    $DBQueryParams = DBQueryParamsClass::CreateParams()
                        ->setOrderBy( "a.id" )
                        ->setOrderType( "ASC" );

                    $this->$field = SiteHelper::getRelation( $relationParams, $DBQueryParams );
                }*/
            }

            return $this->$field;
        }
    }

    /*
    * @desc Общий метод GET
    * @param string $field Название поля
    * @param string $value Значение которое надо положить в поле
    * @return
    */
    public function __set( $field, $value )
    {
        $this->$field = $value;
    }

    /*
    * @desc Вормирование масива полей которые имеют связи
    * @param
    * @return array
    */
    public function getRelationFields()
    {
        $listFields = array();
        foreach( $this->relations() as $key=>$value )
        {
            $listFields[] = $value[2];
        }

        return $listFields;
    }

     public function saveWithRelation()
     {
         $res = $this->save();

         if( $res )
         {
             foreach( $this->relations() as $relation )
             {
                 if( $relation[0] == self::HAS_MANY ) // Один ко многим
                 {
                     $relationTable = $relation[1];
                     $relationField = $relation[2];

                     $relationArray = isset( $_POST[$relationTable] ) ? $_POST[$relationTable] : array();
                     foreach( $relationTable::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0) ) as $relationItem )
                     {
                         if( ( $relationItem->$relationField == $this->id ) || ( in_array( $relationItem->id, $relationArray ) ) )
                         {
                             if( isset( $_POST[$relationTable] ) )
                             {
                                 $relationItem->$relationField =  ( in_array( $relationItem->id, $relationArray ) ) ? $this->id : 0;
                                 $relationItem->save();
                             }
                         }
                     }
                 }

                 if( $relation[0] == self::MANY_MANY ) // Многие ко многим
                 {
                     $thisTable = SiteHelper::getCamelCase( $this->tableName() );
                     $relationTable = $relation[1];

                     $relationArray = isset( $_POST[$thisTable][$relationTable] ) ? $_POST[$thisTable][$relationTable] : array();

                     // Удаляем сохраненные ранее данные
                     $resRelation = CatRelations::fetchAll( DBQueryParamsClass::CreateParams()->setConditions(" ( leftId=:leftId AND leftClass=:leftClass AND rightClass=:rightClass ) OR ( rightId=:leftId AND rightClass=:leftClass AND leftClass=:rightClass ) ")->setParams( array( ":leftId"=>$this->id, ":leftClass"=>$thisTable, ":rightClass"=>$relationTable ) )->setCache(0) );
                     foreach( $resRelation as $item )
                        $item->delete();

                     if( sizeof($relationArray)>0 )
                     {
                         foreach( $relationArray as $relationItem )
                         {
                             $newCatRelation = new CatRelations();
                             $newCatRelation->leftId = (int)$this->id;
                             $newCatRelation->leftClass = $thisTable;
                             $newCatRelation->rightId = (int)$relationItem;
                             $newCatRelation->rightClass = $relationTable;
                             $newCatRelation->save();

                             $newCatRelation = new CatRelations();
                             $newCatRelation->rightId = (int)$this->id;
                             $newCatRelation->rightClass = $thisTable;
                             $newCatRelation->leftId = (int)$relationItem;
                             $newCatRelation->leftClass = $relationTable;
                             $newCatRelation->save();
                         }
                     }
                 }
             }

             return $res;
     }
            else return false;
     }

    /*
    * @desc Делает сохранение в базу текущей модели
    * @param
    * @return bool $result возвражает результат операции TRUE или FALSE
    */
    public function save()
    {

        // TODO надо будет еще сделать рекурсивыное сохранение т.е. чтобы он шол по всем связям проверял
        // если значение нету то проверял валидацию связанной записи и сохранял

        // TODO если есть сохранение сериазиваного масива в поле kesh у объекта, то обновлятять или ощищать kesh

        // ОБработка поле по их типу
        foreach( $this->fieldType() as $field =>$type)
        {
            // Дата
            if( $type == "date" )
            {
                if( property_exists( $this, $field ) && $this->$field && strtotime( $this->$field ) >0 )$this->$field = strtotime( $this->$field );
            }
        }

        if( $this->validate() == false )return false;

        // Закачка файлов
        $catalog = SiteHelper::getCamelCase( get_class( $this ) );
        foreach( $this->fieldType() as $field =>$type)
        {
            if( !empty( $_POST[$catalog]["old_".$field] ) )
                $this->$field = $_POST[$catalog]["old_".$field];

            if( $type == "image" && !empty( $_FILES[$catalog]["tmp_name"][$field] ) )
            {
                $ihelper = new ImageHelper();
                if( $this->$field )$ihelper->deleteFile( $this, $field );

                if( $ihelper->uploadFile( $this, $field, $catalog ) )
                {
                    $this->$field = $ihelper->newFileUrl;
                }
                    else $this->addError( "Ошибка закачки файла", $ihelper->error );
            }

            if( $type == "file" && !empty( $_FILES[$catalog]["tmp_name"][$field] ) )
            {
                $ihelper = new ImageHelper();
                if( $this->$field )$ihelper->deleteFile( $this, $field );

                if( $ihelper->uploadFile( $this, $field, $catalog, false ) )
                {
                    $this->$field = $ihelper->newFileUrl;
                }
                    else $this->addError( "Ошибка закачки файла", $ihelper->error );
            }
        }

        $sqlColumns = "";
        $sqlField = "";
        $sqlUpdateField = "";
        foreach( $this->getSafeAtributes() as $key => $value )
        {
            $value = trim( $value );
            // Скрыл потомучто возникла проблема, с тем что в случае с таблицей I18n и I18n_translate
            // необходимо ложить в талицу I18n_translate указывать определнный ID
            //if( $value=="id" )continue;
            if( !empty( $sqlField ) )$sqlField.=",";

            if( $this->id<0 )
            {
                if( in_array( $value, $this->getRelationFields() ) && is_object( $this->$value ) )
                         $sqlField .= "`".$value."`='".$this->$value->id."'";
                    else $sqlField .= "`".$value."`='".$this->$value."'";
            }
                else
            {
                if( !empty( $sqlColumns ) )
                {
                    $sqlColumns .= ",";
                    $sqlUpdateField .= ",";
                }

                $sqlColumns .= "`".trim( $value )."`";

                if( is_object( $this->$value ) )$this->$value =  $this->$value->id;

                $this->$value = SiteHelper::checkedVaribal( $this->$value );
                $sqlField .= "'".$this->$value."'";
                $sqlUpdateField .= "`".trim( $value )."`='".$this->$value."'";
            }
        }

        // Проверяем существование записи
        $modelClass = SiteHelper::getCamelCase( $this->tableName() );
        if( $this->id>0 )
        {
            $itemObject = $modelClass::fetch( $this->id );
        }
            else $itemObject = new $modelClass();

        if( $itemObject->id>0 )$sql = "UPDATE ".$this->tableName()." SET ".$sqlUpdateField." WHERE id='".$this->id."'";
                          else $sql = "INSERT INTO ".$this->tableName()."(".$sqlColumns.") VALUES( ".$sqlField.")";


        // echo $sql."<br/>";
        $coutUpdateItems = null;
        try
        {
             $coutUpdateItems = Yii::app()->db->createCommand( $sql )->execute();
        }
        catch(Exception $e) // в случае возникновения ошибки при выполнении одного из запросов выбрасывается исключение
        {
            throw new Exception( "Произошла ошибка запроса ( ".$sql." )" );
        }

        if( !$this->id )
        {
            $this->isNewAdded = true;
            $this->id = Yii::app()->db->getLastInsertID();
        }
            else $this->isNewAdded = false;

/*        if( $coutUpdateItems == 0 )
        {
            $this->addError( "NO_EXECUTE", "Запрос не затронул не одной записи ( ".$sql." )" );
            return false;
        }
            else */
        return true;
    }

    public function update( array $fields = array() )
    {
        if( $this->validate() == false || !$this->id )return false;

        // TODO необходиммо подумать над сохранением сериазиваного масива в поле kesh у объекта, то обновлятять или ощищать kesh
        if( Yii::app()->db->createCommand()->update( $this->tableName(), $fields, "id=:id", array( ":id"=>$this->id ) ) )return true;
                    else return false;
    }

     public function getRequiredAttributes()
     {
         foreach( $this->rules() as $key=>$value )
         {
             if( $value[1] == "required" )
                 return explode( ",", $value[0] );
         }
     }

     public function getSearchAttributes()
     {
         foreach( $this->rules() as $key=>$value )
         {
             if( $value[1] == "search" )
             {
                 return explode( ",", $value[0] );
             }
         }
     }

     private function getSafeAtributes()
     {
         foreach( $this->rules() as $key=>$value )
         {
             if( $value[1] == "safe" )
                 return explode( ",", $value[0] );
         }
     }

     /*
     * @desc Возврощает описание одной связи по полю
     * @param string $fieldName Название поля которое имеет связь
     * @return array $relationArray Масив - описание одной связи
     */
     public function getRelationByField( $fieldName )
     {
         foreach( $this->relations() as $key=>$value )
             if( $value[2] == $fieldName || $key == $fieldName )return $value;

         return false;
     }

     public function getRelationByKey( $fieldKey )
     {
         foreach( $this->relations() as $key=>$value )
             if( $key == $fieldKey )return $value;

         return false;
     }

     /*
    * @desc Возврощает описание одной связи по полю
    * @param string $fieldName Название поля которое имеет связь
    * @return array $relationArray Масив - описание одной связи
    */
     public function getRelationByClass( $className )
     {
         foreach( $this->relations() as $value )
             if( $value[1] == $className )return $value;

         return false;
     }

    /*
    * @desc Увеличивает количество просмотров поле col
    * @param
    * @return bool $result статус действия
    */
    public function setColView()
    {
        if( property_exists( $this, "col" ) )
            return $this->update( array( "col"=>$this->col+1 ) );

        return false;
    }

     static function getTableAlias( $table )
     {
         return $table."_as";
     }

    public function getImages()
    {
        return ImageHelper::getImages( $this );
    }

    public function attributeNames()
    {
    }

     /*
      * Задаем если необходимо подсказки/комментарии к полям
      */
     public function attributePlaceholder()
     {
         return array(
             'url'      => 'например: http://www.sitename.ru',
             'www'      => 'например: http://www.sitename.ru',
             'email'    => 'например: info@sitename.ru',
             'tel'    => 'например: +998905555555, +998906666666',
             'fax'    => 'например: +998905555555',
             'address'    => 'например: ул. Амира Тимура, дом 39, офис 55',
             'password' => 'введите пароль',
             'pos'      => 'определяет позицию в общем списке',
             'key_word' => 'системный идентификатор, писать английскими буквами'
         );
     }

    public function tableName()
    {}

     public function __toString()
     {
         return (String) $this->id;
     }

     public function fieldType( )
     {
         return array(
                        "del" => "checkbox",
                        "id"=> "label",
                        "description"=> "visual_textarea",
                        "image"=> "image",
                        "file"=> "file",
                        "date"=> "date",
                        "password"=>"password",
                        "password2"=>"password",
                        "email"=>"email",
                        "site"=>"url",
                        "active"=>"checkbox",
                        "is_active"=>"checkbox"
                    );
     }

     public function getMessage()
     {
         if( $this->formMessage )return '<div class="messageSummary">'.$this->formMessage.'</div>';
     }
}