<?php

require_once( "include/models/m_subscribe.php" );
require_once( "include/service/s_subscribe.php" );

class subscribe
{
    static function getSubscribe()
    {
        return new subscribe();
    }

    public function getList( $message = "" )
    {
        $action = !empty( $_GET["action"] ) ? functions::check( $_GET["action"] ) : "";

        $cout = '<h1>Список рассылок</h1>';
        if( !empty( $message )  )$cout .= functions::getMessage( $message );

        $cout .= functions::getDopMenu( array( array( "title"=>"Добавить", "href"=>"index.php?mofule=subscribe&action=edit" ) ) );
        $cout .= '<table id="centerTable">
                    <tr>
                        <th>ID</th>
                        <th>Тема</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>От</th>
                        <th>Отправленно</th>
                        <th>Действия</th>
                    </tr>';

        $i = 1;
        $list = s_subscribe::create()->getList();
        foreach( $list as $line )
        {
            $i = $i==1 ? 2 : 1;

            switch( $line->status )
            {
                case 1 : $status = "новая";break;
                case 2 : $status = "запущенна";break;
                case 3 : $status = "остановлена";break;
                case 4 : $status = "завершенна";break;
                default : $status = "новая";break;
            }

            $countSend = "-";
            if( $line->status != 1 )
            {
                list( $countSend ) = mysql_fetch_array( mysql_query( "SELECT count( id ) FROM sb_send WHERE subscribe_id='".$line->id."'" ) );
            }

            $cout .= "<tr class=\"SCItem".$i."\">
                        <td>".$line->id."</td>
                        <td><a href=\"index.php?module=subscribe&action=edit&id=".$line->id."\">".$line->subject."</a></td>
                        <td>".functions::dateFormat( $line->date )."</td>
                        <td>".$status."</td>
                        <td>".$line->from."</td>
                        <td class=\"alignCenter\">".$countSend."</td>
                        <td class=\"alignCenter\">
                            <a href=\"index.php?module=subscribe&action=edit&id=".$line->id."\">Редактировать</a>,
                            <a href=\"index.php?module=subscribe&action=delete&id=".$line->id."\">Удалить</a>
                            ".( $line->status != 2 ? "<a href=\"index.php?module=subscribe&action=start&id=".$line->id."\">Запустить</a>" : "<a href=\"index.php?module=subscribe&action=stop&id=".$line->id."\">Остановить</a>" )."
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
            $model = s_subscribe::create()->getByID( $id );
            $title = "Редактирование \"".$model->subject."\"";
            $formAction = "&id=".$id;

        }
            else
        {
            $model = m_subscribe::create();
            $title= "Создание";
            $formAction = "";
        }

        $cout = "<h1>".$title."</h1>
                <form action=\"index.php?module=subscribe&action=save".$formAction."\" method=\"post\">
                ".( !empty( $error ) ? functions::getError( $error ) : "" )."
                    <table id=\"centerTable\">
                        <tr>
                            <th>Тема</th>
                            <td><input type=\"text\" name=\"subject\" value=\"".$model->subject."\"></td>
                        </tr>
                        <tr>
                            <th>От кого</th>
                            <td><input type=\"text\" name=\"from\" value=\"".$model->from."\"></td>
                        </tr>
                        <tr>
                            <th>Текст рассылки</th>
                            <td><textarea name=\"message\" rows=\"10\" cols=\"60\">".$model->message."</textarea></td>
                        </tr>
                        <tr>
                            <td colspan=\"2\"><hr/>Выберите получателей:</td>
                        </tr>
                        <tr>
                            <th><input type=\"radio\" name=\"sender_type\" ".( $model->sender_type == 1 ? "checked" : "" )." value=\"1\" /> Общая отправка:<br/>( письма будут отправлены всем пользоватлеям )</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th><input type=\"radio\" name=\"sender_type\" ".( $model->sender_type == 2 ? "checked" : "" )." value=\"2\" /> Отправка по регионам:<br/>( письма будут отправленны пользоватлеям определенного регоина )</th>
                            <td>
                                <textarea rows=\"6\" name=\"sender_region\" cols=\"50\">".$model->sender_region."</textarea
                            </td>
                        </tr>
                        <tr>
                            <th><input type=\"radio\" name=\"sender_type\" ".( $model->sender_type == 3 ? "checked" : "" )." value=\"3\" /> Индивидуальная отправка:<br/>( писмьа будут отправленны только на Email указанные в этом поле,<br/>разделять запятой )</th>
                            <td>
                                <textarea rows=\"6\" name=\"sender_list\" cols=\"50\">".$model->sender_list."</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"2\"><hr/></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input type=\"hidden\" name=\"status\" value=\"".$model->status."\">
                                <input type=\"submit\" name=\"editSubmit\" value=\"Сохранить\">
                            </td>
                        </tr>
                    </table>
                </form>";

        return $cout;
    }

    public function save()
    {
        $id = !empty( $_GET["id"] ) ? functions::check( $_GET["id"] ) : "";

        if( !empty( $_POST["subject"] ) && !empty( $_POST["from"] ) && !empty( $_POST["message"] ) )
        {
            if( !empty( $id ))$_POST["id"] = $id;
            $subject = functions::check( $_POST["subject"] );
            $from = functions::check( $_POST["from"] );
            $message = functions::check( $_POST["message"] );

            s_subscribe::create()->save( m_subscribe::create()->fromArray( $_POST ) );

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
            $model = s_subscribe::create()->getByID( $id );
            s_subscribe::create()->delete( $id );
            if( !empty( $id ) && $id>0 )mysql_query( "DELETE FROM sb_send WHERE subscribe_id='".$id."'" );
            $message =  "Удалили запись \"".$model->subject."\"";
        }

        $cout = $this->getList( $message );
        return $cout;
    }

    public function start()
    {
        $id = !empty( $_GET["id"] ) ? functions::check( $_GET["id"] ) : "";
        $message = "";
        if( !empty( $id ) )
        {
            $model = s_subscribe::create()->getByID( $id );
            if( $model->status != 2 )
            {
                $model->status = 2;
                s_subscribe::create()->save( $model );
                $message =  "Запустили рассылку \"".$model->subject."\"";
            }
        }

        $cout = $this->getList( $message );
        return $cout;
    }

    public function stop()
    {
        $id = !empty( $_GET["id"] ) ? functions::check( $_GET["id"] ) : "";
        $message = "";
        if( !empty( $id ) )
        {
            $model = s_subscribe::create()->getByID( $id );
            if( $model->status == 2 )
            {
                $model->status = 3;
                s_subscribe::create()->save( $model );
                $message =  "Остановили рассылку \"".$model->subject."\"";
            }
        }

        $cout = $this->getList( $message );
        return $cout;
    }
}

$acion="";
if( !empty( $_GET["action"] ) )$acion = functions::check( $_GET["action"] );
switch( $acion )
{
    case "edit"      : $coutCenter = subscribe::getSubscribe()->getEdit(); break;
    case "save"      : $coutCenter = subscribe::getSubscribe()->save(); break;
    case "save_ok"   : $coutCenter = subscribe::getSubscribe()->getList(); break;
    case "delete"    : $coutCenter = subscribe::getSubscribe()->delete(); break;
    case "start"     : $coutCenter = subscribe::getSubscribe()->start(); break;
    case "stop"      : $coutCenter = subscribe::getSubscribe()->stop(); break;
    default          : $coutCenter = subscribe::getSubscribe()->getList(); break;
}

echo $coutCenter;