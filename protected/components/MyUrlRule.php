<?php
class MyUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';

    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='car/index')
        {
            if (isset($params['manufacturer'], $params['model']))
                return $params['manufacturer'] . '/' . $params['model'];
            else if (isset($params['manufacturer']))
                return $params['manufacturer'];
        }
        return false;  // не применяем данное правило
    }

    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches))
        {
            // Проверяем $matches[1] и $matches[3] на предмет
            // соответствия производителю и модели в БД.
            // Если соответствуют, выставляем $_GET['manufacturer'] и/или $_GET['model']
            // и возвращаем строку с маршрутом 'car/index'.
        }
        return false;  // не применяем данное правило
    }
}