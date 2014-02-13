<?php

class CCmodelHelper
{
    static function colCounter( CCModel $model )
    {
        $model->col = $model->col>0 ? $model->col + 1 : 1;
        if( !$model->save() )print_r( $model->getErrors() );
    }

    static function getLimitText( $text, $limit )
    {
        if( !empty( $limit ) )
        {
            $arText = explode( " ", strip_tags( $text ) );
            $text = "";
            for( $i=0;( $i<sizeof($arText) && ( $i<$limit ) );$i++ )
                $text .= $arText[$i]." ";

            if( sizeof($arText)>$limit )$text .= " ...";
            return $text;
        }
    }

    static function getRelationItems( $relation, CCModel $model )
    {
        $relationTable = $relation[1];
        // $relationItems = "";
        // if( $relation[0] == CCModel::HAS_MANY )$relationItems = $relationTable::fetchall( DBQueryParamsClass::CreateParams()->setConditions( $relation[2]."=:".$relation[2])->setParams( array( $relation[2]=>$model->id )) );
        // if( $relation[0] == CCModel::BELONGS_TO )
            $relationItems = $relationTable::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0)->setOrderBy("pos, name")->setLimit(-1) );

        return $relationItems;
    }

    static function addForm( $form, $captcha = false, Controller $controller = null  )
    {
        $fields = $form->attributeLabels();
        $relationList = $form->getRelationFields();
        $relations = $form->relations();
        $fieldType = $form->fieldType();
        $requiredFields = $form->getRequiredAttributes();
        $placeholder = $form->attributePlaceholder();

        $cout = "";
        $classTable = get_class( $form );

        foreach( $fields as $field=>$key )
        {
            // Если идет добаление элемента но произошла ошибка то воспроизводит введеные значения
            $paramValue = ( !empty( $_POST[ $classTable ][$field] ) ) ? $_POST[ $classTable ][$field] : "";
            if( !empty( $paramValue ) && !$form->$field )$form->$field = $paramValue;
            // end

            // Вытаскиваем тип поля
            $fieldTypeValue = ( !empty( $fieldType[ $field ] ) ) ? $fieldTypeValue = $fieldType[ $field ] : "";

            if( !in_array( $field, $relationList ) &&
                ( empty($fieldTypeValue) || empty( $relations[ $fieldTypeValue ] ) ) )// проверяем нет ли связи один ко многим у данного поля
            {
                // Подсказка к полю
                if( !empty( $placeholder[ $field ] ) )$fieldPlaceholder = $placeholder[ $field ];
                    else $fieldPlaceholder = "";

                if( !empty( $fieldType[$field] ) )
                {
                    $input = "";
                    switch( $fieldType[ $field ] )
                    {
                        case "url"             : $input = CHtml::activeUrlField( $form, $field, array( "placeholder"=>$fieldPlaceholder ) )."<br/><font class='smallGrey'>формат: http://www.sitename.ru</font>"; break;
                        case "email"           : $input = CHtml::activeEmailField( $form, $field, array( "placeholder"=>$fieldPlaceholder ) ); break;
                        case "date"            :
                            if( (int)$form->$field >0 )$form->$field = date( "Y-m-d", $form->$field );
                            $input = CHtml::activeDateField( $form, $field, array( "placeholder"=>$fieldPlaceholder ) ); break;
                        case "password"        : $input = CHtml::activePasswordField( $form, $field, array( "placeholder"=>$fieldPlaceholder ) ); break;
                        case "checkbox"        : $input = CHtml::activeCheckBox( $form, $field, array( "placeholder"=>$fieldPlaceholder ) ); break;
                        case "visual_textarea" : $input = CHtml::activeTextArea( $form, $field, array( "cols"=>50, "rows"=>10, "class"=>"tinymce", "placeholder"=>$fieldPlaceholder ) ); break;
                        case "image"           :

                            if( $form->$field  )
                            {
                                $catalog = get_class( $form );
                                $input = '<img src="../'.ImageHelper::getImage( $form->$field, 2, $form ) .'" width="100" /><br/>';
                                if( Yii::app()->controller->module->id == "console" )$input .= '<a href="'.SiteHelper::createUrl( "/console/catalog/edit", array("id"=>$form->id) )."?catalog=".$catalog."&action=img_del&field=".$field.'">[удалить]</a><br/>';
                                $input .= CHtml::hiddenField( $catalog."[old_".$field."]", $form->$field );
                            }
                            $input .= CHtml::activeFileField( $form, $field );

                            break;
                        case "file"            :
                            if( $form->$field  )
                            {
                                $catalog = get_class( $form );
                                $input = '<a href="../'.$form->$field.'" target="_blank">'.$form->$field.'</a><br/>';
                                if( Yii::app()->controller->module->id == "console" )$input .= '<a href="'.SiteHelper::createUrl( "/console/catalog/edit", array("id"=>$form->id) )."?catalog=".$catalog."&action=img_del&field=".$field.'">[удалить]</a><br/>';
                                $input .= CHtml::hiddenField( $catalog."[old_".$field."]", $form->$field );
                            }
                            $input .= CHtml::activeFileField( $form, $field ); break;
                        case "label"           : $input = $form->$field; break;
                        default                : $input = CHtml::activeTextField( $form, $field, array( "placeholder"=>$fieldPlaceholder ) );
                    }
                }
                    else $input = CHtml::activeTextField( $form, $field, array("placeholder"=>$fieldPlaceholder) );
            }
                else
            {
                $input = "";

                // проверяем нет ли привязки данного поля к сязи один ко многим
                if( !empty($fieldTypeValue) && !empty( $relations[ $fieldTypeValue ] ) )$relation = $relations[ $fieldTypeValue ]; // Привязка один ко многим
                        else $relation = $form->getRelationByField( $field );                                                      // привязка один к одному

                $relationItems = CCmodelHelper::getRelationItems( $relation, $form );

                $fieldName = $field;
                $paramValue = ( !empty( $_POST[ $classTable ][$fieldName] ) ) ? (int)$_POST[ $classTable ][$fieldName] : 0;

                if( sizeof( $relationItems ) >0 )
                {
                    if( $relation[0] == CCModel::HAS_MANY || $relation[0] == CCModel::MANY_MANY )
                    {
                        $relationModel = RelationParamsClass::CreateParams()
                                        ->setLeftId( $form->id )
                                        ->setLeftClass( $classTable )
                                        ->setRightClass( $relation[1] ) ;

                        $listValues = SiteHelper::getRelation( $relationModel );
                        $input .=    '<div class="relationListItems">
                                            <ul>';

                        foreach( $relationItems as $relationData )
                        {
                            if( !empty( $listValues[ $relationData->id ] ) )$checked = "checked=\"checked\"";
                                    else $checked = "";

                            $input .= '<li><input type="checkbox" name="'.$classTable .'['.$relation[1].'][]" '.$checked.' value="'.$relationData->id.'" id="'.$fieldName."_".$relationData->id.'" /><label for="'.$fieldName."_".$relationData->id.'">'.$relationData->name.'</li>';
                        }

                        $input .=   '       </ul>
                                     </div>';
                    }
                        else
                    {
                        if( !empty( $paramValue ) && !$form->$fieldName )$selectedID = $paramValue;
                            else $selectedID = "";

                        $input .= '<select name="'.$classTable .'['.$fieldName.']" class="field_'.$fieldName.'">
                                        <option value="0"> --- --- --- </option>';
                        $input .= self::getRelationListOptions( $form, $fieldName, $relationItems, $selectedID );
                        $input .= '</select>';
                    }
                }
            }

            if( !empty( $input ) )
            {
                if( self::find_in_array( $field, $requiredFields ) )$required = " <font class=\"colorRad\">*</font>";
                                                    else $required = "";
                $cout .= '<tr>
                             <th>'.$fields[ $field ].$required.':</th>
                             <td>'.$input.'</td>
                          </tr>';
            }
        }



        if( !empty( $captcha ) )
        {
            $cout .=
                '<tr>
                    <th width="150">'.Yii::t("system", "Verification code").': <font class="redColor">*</font></th>
                    <td>';

            $cout .= $controller->widget('CCaptcha', array('buttonLabel' => '<br>['.Yii::t("system", "new code").']'), true);
            $cout .= CHtml::activeTextField($form, 'captcha', array( 'class'=>'validate[required]' )) .'
                    </td>
                </tr>';
        }

        return $cout;
    }

    static function infoForm( $form )
    {
        $fields = $form->attributeLabels();
        $relationList = $form->getRelationFields();
        $relations = $form->relations();
        $fieldType = $form->fieldType();
        $requiredFields = $form->getRequiredAttributes();
        $placeholder = $form->attributePlaceholder();

        $cout = "";
        $classTable = get_class( $form );

        foreach( $fields as $field=>$key )
        {
            if( !$form->$field  )continue;

            // Вытаскиваем тип поля
            $fieldTypeValue = ( !empty( $fieldType[ $field ] ) ) ? $fieldTypeValue = $fieldType[ $field ] : "";

            if( !in_array( $field, $relationList ) &&
                ( empty($fieldTypeValue) || empty( $relations[ $fieldTypeValue ] ) ) )// проверяем нет ли связи один ко многим у данного поля
            {
                // Подсказка к полю
                if( !empty( $placeholder[ $field ] ) )$fieldPlaceholder = $placeholder[ $field ];
                                else $fieldPlaceholder = "";

                if( !empty( $fieldType[$field] ) )
                {
                    $input = "";
                    switch( $fieldType[ $field ] )
                    {
                        case "url"             : $input = '<a href="'.$form->$field.'" target="_blank">'.$form->$field.'</a>'; break;
                        case "email"           : $input = '<div><a href="#" onclick="$(this.parentNode).load(\''.SiteHelper::createUrl("site/getInfo", array("catalog"=>"catalogFirms", "id"=>$form->id, "field"=>"email")).'\' ); return false;"> [ показать email ]</a></div>'; break;
                        case "date"            : $input = date( "Y-m-d", $form->$field );break;
                        case "checkbox"        : $input = "+"; break;
                        case "visual_textarea" : $input = $form->$field; break;
                        case "image"           : $input = '<img src="../'.ImageHelper::getImage( $form->$field, 2, $form ) .'" width="100" /><br/>';break;
                        case "file"            : $input = '<a href="../'.$form->$field.'" target="_blank">'.$form->$field.'</a><br/>';break;
                        default                : $input = $form->$field;
                    }
                }
                else $input = $form->$field;
            }
            else
            {
                $input = "";

                // проверяем нет ли привязки данного поля к сязи один ко многим
                if( !empty($fieldTypeValue) && !empty( $relations[ $fieldTypeValue ] ) )$relation = $relations[ $fieldTypeValue ]; // Привязка один ко многим
                else $relation = $form->getRelationByField( $field );                                                      // привязка один к одному

                $relationItems = CCmodelHelper::getRelationItems( $relation, $form );

                $fieldName = $field;

                if( sizeof( $relationItems ) >0 )
                {
                    if( $relation[0] == CCModel::HAS_MANY || $relation[0] == CCModel::MANY_MANY )
                    {
                        /*
                        $relationModel = RelationParamsClass::CreateParams()
                            ->setLeftId( $form->id )
                            ->setLeftClass( $classTable )
                            ->setRightClass( $relation[1] ) ;

                        $listValues = SiteHelper::getRelation( $relationModel );
                        $input .=    '<div class="relationListItems">
                                            <ul>';

                        foreach( $relationItems as $relationData )
                        {
                            if( !empty( $listValues[ $relationData->id ] ) )$checked = "checked=\"checked\"";
                            else $checked = "";

                            $input .= '<li><input type="checkbox" name="'.$classTable .'['.$relation[1].'][]" '.$checked.' value="'.$relationData->id.'" id="'.$field[1]."_".$relationData->id.'" /><label for="'.$field[1]."_".$relationData->id.'">'.$relationData->name.'</li>';
                        }

                        $input .=   '       </ul>
                                     </div>';
                        */
                    }
                    else
                    {
                        $input = $form->$fieldName->name;
                    }
                }
            }

            if( !empty( $input ) )
            {
                $cout .= '<tr>
                             <th>'.$fields[ $field ].':</th>
                             <td>'.$input.'</td>
                          </tr>';
            }
        }

        return $cout;
    }

    private static function find_in_array( $text, $array )
    {
        if( is_array( $array ) )
        {
            foreach( $array as $key=>$value )
            {
                $value = trim( strtolower( $value ) );
                if( $value == $text )
                {
                    return true;
                }
            }
        }
        return false;
    }

    private static function getRelationName( $name )
    {
        $name = strtolower( $name );
        foreach( Yii::app()->params["catalogList"] as $key=>$value )
        {
            $key = strtolower( $key );
            if( strtolower( $key ) == $name )return $value;

            if( is_array( $value ) )
            {
                foreach( $value as $key2=>$value2 )
                {
                    if( $key2 == $name )return $value2;
                }
            }
        }

        return false;
    }

    public static function getRelationListOptions( $form, $fieldName, $relationItems, $selectedID = 0 )
    {
        $formClass = get_class( $relationItems[0] );
        // Проверяем если есть поле OWNER ссылающиеся ссылающиеся на эту же таблицу делаем вывод категории с OPTIONGROUP
        $modelFormClass = new $formClass();
        $ownerRelation = $modelFormClass->getRelationByClass( $formClass );

        if( is_array( $ownerRelation ) && $ownerRelation[2] == "owner" )
        {
            $cout = "";

            // Если форма редактирования открыто в консоле то даем возможность выбора OWNER позиций
            if( !empty( Yii::app()->controller->module ) && Yii::app()->controller->module->getId() != "console" )
            {
                foreach( $formClass::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("owner=:owner")->setParams( array(":owner"=>0) )->setLimit(-1)->setOrderBy("pos, name") ) as $relationData )
                {
                    $cout .= '<optgroup label="'.$relationData->name.'">';
                    foreach( $formClass::findByAttributes( array("owner"=>$relationData->id) ) as $relationData2 )
                    {
                        if( $relationData2->id == $form->$fieldName )$sel = "selected";
                            else $sel = "";

                        if( empty( $sel ) )
                        {
                            if( $selectedID == $relationData2->id )$sel = "selected";
                                                              else $sel = "";
                        }

                        $cout .= '<option value="'.$relationData2->id.'" '.$sel.'>'.$relationData2->name.'</option>';
                    }
                    $cout .= '</optgroup>';
                }
            }
                else
            {
                foreach( $formClass::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("owner=:owner")->setParams( array(":owner"=>0) )->setLimit(-1)->setOrderBy("pos, name") ) as $relationData )
                {
                    if( $relationData->id == $form->$fieldName )$sel_ = "selected";
                    else $sel_ = "";

                    if( empty( $sel_ ) )
                    {
                        if( $selectedID == $relationData->id )$sel_ = "selected";
                        else $sel_ = "";
                    }

                    $cout .= '<option value="'.$relationData->id.'" '.$sel_.'>'.$relationData->name.'</option>';
                    foreach( $formClass::findByAttributes( array("owner"=>$relationData->id) ) as $relationData2 )
                    {
                        if( $relationData2->id == $form->$fieldName )$sel = "selected";
                            else $sel = "";

                        if( empty( $sel ) )
                        {
                            if( $selectedID == $relationData2->id )$sel = "selected";
                                else $sel = "";
                        }

                        $cout .= '<option value="'.$relationData2->id.'" '.$sel.'> --- '.$relationData2->name.'</option>';
                    }
                }

            }

        }
            else
        {
            $cout = "";
            foreach( $relationItems as $relationData )
            {
                if( $relationData->id == $form->$fieldName )$sel = "selected";
                else $sel = "";

                if( empty( $sel ) )
                {
                    if( $selectedID == $relationData->id )$sel = "selected";
                    else $sel = "";
                }

                $cout .= '<option value="'.$relationData->id.'" '.$sel.'>'.$relationData->name.'</li>';
            }
        }

        return $cout;
    }

    static function getInputField( CCModel $form, $field, $needEmpty = true )
    {
        $listType = $form->fieldType();
        $tableClass = SiteHelper::getCamelCase( $form->tableName() );
        $value = !empty( $_POST[$tableClass] ) && !empty( $_POST[$tableClass][$field] ) ? $_POST[$tableClass][$field] : "";
        $HTMLOption = "";
        $fieldType = $form->fieldType();

        if( !empty( $listType[$field] ) )
        {
            $fieldName = $tableClass."[".$field."]";

            switch( $listType[$field] )
            {
                case "checkbox"         :$input= CHtml::checkBox( $fieldName, $value ); break;
                case "visual_textarea"  :$input= CHtml::textArea( $fieldName, $value ); break;
                case "url"              :$input= CHtml::activeUrlField( $form, $field ); break;
                case "date"             :
                    $input= "от: ".CHtml::textField( $fieldName, $value, array("class"=>"yearField") );
                    $input.= "&nbsp;&nbsp;до: ".CHtml::textField( $tableClass."[".$field."_2]", $value, array("class"=>"yearField") );
                    break;
            }
        }

        // Выводим списк связей
        if( empty( $input ) )
        {
            if( $relation = $form->getRelationByField( $field ) )
            {
                $input = '<select name="'.$tableClass.'['.$field.']" class="field_'.$field.'">';
                if( !empty( $needEmpty ) )$input .= '<option value=""> --- --- --- </option>';
                $input .= CCmodelHelper::getRelationListOptions( $form, $field, CCmodelHelper::getRelationItems( $relation, $form ), $value );
                $input .= '</select>';
            }
        }

        if( empty( $input ) )
        {
            if( !empty( $fieldType[$field] ) && $fieldType[$field] == "integer" )
            {
                $value_2 = !empty( $_POST[$tableClass] ) && !empty( $_POST[$tableClass][$field."_2"] ) ? $_POST[$tableClass][$field."_2"] : "";

                $input= "от: ".CHtml::textField( $fieldName, $value, array("class"=>"yearField") );
                $input.= "&nbsp;&nbsp;до: ".CHtml::textField( $tableClass."[".$field."_2]", $value_2, array("class"=>"yearField") );
            }
                else
                    $input= CHtml::activeTextField( $form, $field );
        }

        return $input;
        // Определяем это поле релайшин или нет
        // Если не релайшин то вывести <input type="text" иначе
    }
}
