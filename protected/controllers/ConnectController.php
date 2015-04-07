<?php

class ConnectController extends InfoController
{
    private $securityKey;
    private $securityIP;

    public function init()
    {
        parent::init();
        $this->securityKey = Yii::app()->params["connect"]["key"];
        $this->securityIP = Yii::app()->params["connect"]["ip"];

    }

    public function actionTest()
    {
        // if( $this->beginCache( "ключ" , array('duration'=>3600) ) )
        // {$this->endCache();}
        $topShow = 2005;
        $topTorShow = 4742;

        $getKey = Yii::app()->request->getParam("key", "");
        $email = Yii::app()->request->getParam("email", "");
        //echo md5( substr( md5( $email.$this->securityKey ), 0, 15) );
        if( $getKey == md5( substr( md5( $email.$this->securityKey ), 0, 15) ) )
        {
            $cout = "";
            $list = CatLogFirms::sql( "SELECT l.firm_id as `id`, l.action_show as `show`, l.date_from as `date`, f.name as fname, f.id as fid FROM cat_log_firms l, catalog_firms f WHERE l.firm_id=f.id AND f.email='".$email."'" );
            if( !empty( $list[0]["fid"] ) )
            {
                $tours = CatLogFirms::sql("SELECT sum(l.action_show) as tshow, sum( l.action_contact ) as tcont FROM cat_log_tours l WHERE l.tour_id in ( SELECT id FROM catalog_tours WHERE firm_id='" . $list[0]["fid"] . "')");

                $item = $list[0];
                $tour = $tours[0];

                $date = date("d.m.Y", $item["date"]);

                // Ессли вообще нету просмотром либо фирмы либо туров

                $nashBron = $tour["tcont"] + ($tour["tshow"] / 5);
                if ($nashBron > 300) $nashBron = round($nashBron / 15, 0);
                else $nashBron = round($nashBron / 10, 0);

                $cout .= "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;\">
                        <table width=\"590\" cellpadding=\"0\" cellspacing=\"0\" style=\"line-height: 18px;color:#000;font-size:14px;\">
                        <tr style=\"overflow:hidden;text-align: justify;line-height: 16px;\">
                        <td colspan=\"2\" style=\"line-height: 18px;font-size: 14px;font-family: times New Roman;padding:0px;\">
                                    <h2>Статистика посещения страницы фирмы \"" . $item["fname"] . "\" на портале World-Travel.uz</h2>
                                    <table>
                        <tr>
                            <th style='text-align:left'>Период статистики:</th>
                            <td>от " . $date . " до " . date("d.m.Y") . "</td>
                        </tr>
                        <tr>
                            <th style='text-align:left'>Просмотров страницы профиля компании:</th>
                            <td>" . ($item["show"] > 0 ? $item["show"] : 0) . "</td>
                        </tr>
                         <tr>
                            <th style='text-align:left'>Сумма просмотров всех Ваших туров:</th>
                            <td>" . ($tour["tshow"] ? $tour["tshow"] : 0) . "</td>
                        </tr>
                         <tr>
                            <th style='text-align:left'>Сумма нажатия кнопки бронирования, на всех турах:</th>
                            <td>" . $nashBron . "</td>
                        </tr>
                    </table>";

                if ($tour["tcont"] < ($tour["tshow"] / 2)) {
                    $cout .= "<p>У вас очень низкий процент нажатия на кнопку бронирования Ваших туров.</p>";
                }

                $cout .= "</td></tr></table></div>";

                $cout .= "<div style=\"background: url(http://subscribes.uz/f/mails/world-travel/block_bg.jpg) no-repeat center;height:31px;\"></div>";

                if (empty($tour["tshow"]) || $tour["tshow"] == 0) {
                    $countTours = CatalogTours::findByAttributes(array("firm_id" => $list[0]["fid"]));
                    if (sizeof($countTours) == 0) {
                        $cout .= "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;\">
                        <table width=\"590\" cellpadding=\"0\" cellspacing=\"0\" style=\"line-height: 18px;color:#000;font-size:14px;\">
                        <tr style=\"overflow:hidden;text-align: justify;line-height: 16px;\">
                        <td colspan=\"2\" style=\"line-height: 18px;font-size: 14px;font-family: times New Roman;padding:0px;\">
                            <h2>В Вашей компании нету туров?</h2>
                            <p>Вы не добавили не одного тура, если вы действительно хотите привлечь внимание к своей компании, туры неотъемлемая часть.<br/>Возможно у Вас возникли какие-то проблемы при добавлении? Персональный консультат поможет вам решить все проблемы.</p></td></tr></table></div>";

                        $cout .= "<div style=\"background: url(http://subscribes.uz/f/mails/world-travel/block_bg.jpg) no-repeat center;height:31px;\"></div>";
                    }
                }
                // Если низки процент бронирования

                // Если низки процент бронирования
                if ($tour["tshow"] < $topTorShow || $item["show"] < $topShow) {
                    $cout .= "<div style=\"background: #e4ddcd;padding: 0px 10px 10px 10px;\">
                        <table width=\"590\" cellpadding=\"0\" cellspacing=\"0\" style=\"line-height: 18px;color:#000;font-size:14px;\">
                        <tr style=\"overflow:hidden;text-align: justify;line-height: 16px;\">
                        <td colspan=\"2\" style=\"line-height: 18px;font-size: 14px;font-family: times New Roman;padding:0px;\">
                            <h2>Чем вы хуже своих конкурентов?</h2>
                            <p>Статистика посещаемости одного из Ваших конкурентов (мы не называем название компании):<ul>";

                    if ($tour["tshow"] < $topTorShow) $cout .= "<li>Сумма просмотров всех туров конкурента <b>" . $topTorShow . "</b> в месяц, а у Вас <b>" . ($tour["tshow"] > 0 ? $tour["tshow"] : 0) . "</b> просмотров</li>";
                    if ($item["show"] < $topShow) $cout .= "<li>Просмотр страницы компании конкурента <b>" . $topShow . "</b> в месяц, а у Вас <b>" . ($item["show"] > 0 ? $item["show"] : 0) . "</b> просмотров</li>";

                    $cout .= "</ul></p></td></tr></table></div>";

                    $cout .= "<div style=\"background: url(http://subscribes.uz/f/mails/world-travel/block_bg.jpg) no-repeat center;height:31px;\"></div>";
                }

                echo $cout;
            }
        }
    }
}