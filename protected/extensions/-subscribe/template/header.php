<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="ru" />
    <title>Рассылка</title>
    <link href="template/css/style.css" rel="stylesheet" type="text/css" />
    <base href="http://www.embassyalliance.ru/subscribe/">
</head>
<body>
<?php
    if( !empty( $_SESSION["s_user"] ) && $_SESSION["s_user"]["id"] >0 )
        include( "template/menu.php" );
?>