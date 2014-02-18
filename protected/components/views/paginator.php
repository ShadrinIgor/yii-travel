<?php

/*if( !$cid )$cid = $_SESSION["sql.cid"];
if( !$where )$where = $_SESSION["sql.sql"];
$dop_url = $_SESSION["sql.dop_url"];
*/

if($count>$offset)
{
    $finish=ceil($count/$offset);
    $c_cout="";

    for($i=1;$i<=$finish;$i++)
    {

        $elem="";

        if($i==$page)$elem='<b id="list_activ">'.$i.'</b>';
        else
        {
            if((($i>($page-5))&&($i<($page+5)))||($i==1)||($i==$finish))
            {
                if( empty( $url ) )$elem.="<a href=\"".$defaultUrl."?p=".$i."\">".$i."</a>";
                    elseif( is_array( $url ) ) $elem.="<a href=\"".SiteHelper::createUrl( $url[0], array_merge( $url[1], array( "p"=>$i ) ) ) ."\">".$i."</a>";
                        else $elem.="<a href=\"".$defaultUrl."?p=".$i.$url."\">".$i."</a>";
                $space="";
            }
            else
            {
                if(!$space){$elem.= "<font> ... </font>";$space=1;}
            }
        }

        $c_cout.=$elem;
    }

    $cout = "Страницы: ".$c_cout;
    echo "<div class=\"pageList\">".$cout."  Всего : ".$count."</div>";
}