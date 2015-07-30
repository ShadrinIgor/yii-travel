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

        if($i==$page)$elem='<li class="active"><a href="'.$defaultUrl."?p=".$i.'">'.$i.'</a></li>';
        else
        {
            if((($i>($page-5))&&($i<($page+5)))||($i==1)||($i==$finish))
            {
                if( empty( $url ) )$elem.="<li><a href=\"".$defaultUrl."?p=".$i."\">".$i."</a></li>";
                    elseif( is_array( $url ) ) $elem.="<li><a href=\"".SiteHelper::createUrl( $url[0], array_merge( $url[1], array( "p"=>$i ) ) ) ."\">".$i."</a></li>";
                        else $elem.="<li><a href=\"".$defaultUrl."?p=".$i.$url."\">".$i."</a></li>";
                $space="";
            }
            else
            {
                if(!$space){$elem.= '<li><span> ... </span></li>';$space=1;}
            }
        }

        $c_cout.=$elem;
    }

    echo '<div class="well textAlignCenter">Страницы:<br/><ul class="pagination">'.$c_cout."</ul></div>";
}