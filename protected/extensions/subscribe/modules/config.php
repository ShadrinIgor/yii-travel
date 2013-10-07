<?php

require_once( "include/models/m_config.php" );
require_once( "include/service/s_config.php" );

class config
{
    static function getconfig()
    {
        return new config();
    }

    public function getList( $message = "" )
    {
        $action = !empty( $_GET["action"] ) ? functions::check( $_GET["action"] ) : "";

        $cout = '<h1>Настройки</h1>';
        if( !empty( $message )  )$cout .= functions::getMessage( $message );

        $cout .= functions::getDopMenu( array( array( "title"=>"Добавить", "href"=>"index.php?mofule=config&action=edit" ) ) );
        $cout .= '<table id="centerTable">
                    <tr>
                        <th>Ключ</th>
                        <th>Значение</th>
                        <th>Действия</th>
                    </tr>';

        $i = 1;
        $list = s_config::create()->getList();
        foreach( $list as $line )
        {
            $i = $i==1 ? 2 : 1;

            $cout .= "<tr class=\"SCItem".$i."\">
                        <td>".$line->key."</td>
                        <td>".$line->value."</td>
                        <td class=\"alignCenter\">
                            <a href=\"index.php?module=config&action=edit&id=".$line->id."\">Редактировать</a>,
                            <a href=\"index.php?module=config&action=delete&id=".$line->id."\">Удалить</a>
                        </td>
                      </tr>";
        }

        $cout .= "</table>";
        return $cout;
    }

    public function getEdit( $itemID = 0, $error = "" )
    {
        if( empty( $itemID ) )$id = !empty( $_GET["id"] ) ? functions::check( $_GET["id"] ) : 0;
                         else $id = $itemID;

        if( !empty( $id ) )
        {
            $model = s_config::create()->getByID( $id );
            $title = "Редактирование \"".$model->key."\"";
            $formAction = "&id=".$id;

        }
            else
        {
            $model = m_config::create();
            $title= "Создание";
            $formAction = "";
        }

        $cout = "<h1>".$title."</h1>
                <form action=\"index.php?module=config&action=save".$formAction."\" method=\"post\">
                ".( !empty( $error ) ? functions::getError( $error ) : "" )."
                    <table id=\"centerTable\">
                        <tr>
                            <th>Ключ</th>
                            <td><input type=\"text\" name=\"key\" value=\"".$model->key."\"></td>
                        </tr>
                        <tr>
                            <th>Значение</th>
                            <td><input type=\"text\" name=\"value\" value=\"".$model->value."\"></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><input type=\"submit\" name=\"editSubmit\" value=\"Сохранить\"></td>
                        </tr>
                    </table>
                </form>";

        return $cout;
    }

    public function save()
    {
        $id = !empty( $_GET["id"] ) ? functions::check( $_GET["id"] ) : "";

        if( !empty( $_POST["key"] ) && !empty( $_POST["value"] )  )
        {
            if( !empty( $id ))$_POST["id"] = $id;
            $key = functions::check( $_POST["key"] );
            $value = functions::check( $_POST["value"] );

            s_config::create()->save( m_config::create()->fromArray( $_POST ) );

            $cout = $this->getList( "Данные успешно сохраннены" );
        }
            else
        {
            $cout = $this->getEdit( $id, "Необходимо заполнить все поля" );
        }
        return $cout;
    }

    public function delete()
    {
        $id = !empty( $_GET["id"] ) ? functions::check( $_GET["id"] ) : "";
        $message = "";
        if( !empty( $id ) )
        {
            $model = s_config::create()->getByID( $id );
            s_config::create()->delete( $id );
            $message =  "Удалили запись \"".$model->subject."\"";
        }

        $cout = $this->getList( $message );
        return $cout;
    }
}

$acion="";
if( !empty( $_GET["action"] ) )$acion = functions::check( $_GET["action"] );
switch( $acion )
{
    case "edit"      : $coutCenter = config::getconfig()->getEdit(); break;
    case "save"      : $coutCenter = config::getconfig()->save(); break;
    case "save_ok"   : $coutCenter = config::getconfig()->getList(); break;
    case "delete"    : $coutCenter = config::getconfig()->delete(); break;
    default          : $coutCenter = config::getconfig()->getList(); break;
}

echo $coutCenter;