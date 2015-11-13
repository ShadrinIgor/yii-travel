<?php
    $this->widget('addressLineWidget', array(
        'links'=>array(
               Yii::t("page", "Лучшие новогодние туры на 2015 год")
            )
    ));
?>
<h1>Лучшие новогодние тур. предложения 2015 года, со всего Узбекистана</h1>
<?php if( !Yii::app()->user->isGuest ) : ?>
<div class="panel panel-default">
    <div class="panel-heading"><b>Новый туристический год уже стучится в двери и надо успеть вовремя её открыть</b></div>
    <div class="panel-body">
        Новогодние праздники не за горами, а это значит, что уже сейчас необходимо задуматься о том, как помочь любителям путешествий с их организацией. Как это сделать?  Да просто надо как можно быстрей начать размещать на нашем сайте свои предложения по организации празднования Нового года. А мы постараемся оперативно донести их до потенциальных потребителей.<br/>
        Чтобы помочь вам в этом мы решили запустить на нашем портале раздел НОВОГОДНИЕ ПРЕДЛОЖЕНИЯ. Все поступающие в него предложения будут рекламироваться на нашем сайте, а также с помощью рассылок и социальных сетей.<br/>
    </div>
</div>
<?php endif; ?>
<div id="Buttons" class="BBig">
    <div class="B01">
        <a href="#myModal" data-toggle="modal" title="Разместить свои новогодние предложения БЕСПЛАТНО">
            <br/>
            <b>Вы работает в тур. фирме? Хотите разместить свои новогодние предложения БЕСПЛАТНО ?</b>
        </a>
    </div>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Вы можете разместить все свои новогодние предложения БЕСПЛАТНО</h4>
                </div>
                <div class="modal-body text-justify">
                    <p>Мы предлогам вам абсолютно БЕСПЛАТНО разместить все ваши новогодние туры и предложения на нашем сайте в новом разделе.<br/>
                        Все что для этого нужно:
                    <ol>
                        <li>Авторизоваться или зарегистрироваться, если вы не зарегистрированы</li>
                        <li>Перейти в раздел <a hrf="<?= SiteHelper::createUrl( "/user/tours") ?>">ТУРЫ</a> в персональном кабинете</li>
                        <li>Создать новый туры, или отредактировать существующий.</li>
                        <li>Опубликовать тур ( нажав на ссылку ОПУБЛИКОВАТЬ )</li>
                    </ol>
                    <br/>
                    <b>ОБЯЗАТЕЛЬНО!!!</b> Поставить галочку в графе "НОВОГОДНЕЕ ПРЕДЛОЖЕНИЕ", на странице описания тура.<br/>
                    <br/>
                    <b>ВНИМАНИЕ!!!</b> В рекламную рассылку войдут не все записи, а только лучшие из них. Поэтому вам необходимо подробно описать ваши новогодние предложение, заполнить все поля, загрузить картинки для Вашего тура и обязательно заполнить графу "цена от". Посетителям нашего сайта мы предложим только лучшие предложения, и мы хотим, чтобы ваши предложения стали именно такими.<br/>
                    <br/>
                    Мы желаем вам успехов в грядущем сезоне! И выражаем уверенность, что наше сотрудничество будет в значительной мере способствовать этому.<br/><br/>
                    Если у вас будут вопросы пишите нам на почту <a href="mailto:info@world-travel.uz">info@world-travel.uz</a> и мы вам обязательно поможем.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
<br/><br/>
<div id="catalogItems" class="NYitems">
<?php foreach( $country as $item ) :
    $minPriceModel = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "active=1 AND is_newyear=1 AND country_id='".$item->id."' AND price>0")->setOrderBy("price")->setLimit(1) );
    $countItems = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "active=1 AND is_newyear=1 AND country_id='".$item->id."'") );
    if( sizeof( $minPriceModel ) > 0 )$minPrice = $minPriceModel[0]->price." ".$minPriceModel[0]->currency_id->title;
                            else $minPrice = 0;


?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <?php if( $item->flag ) : ?><img src="<?= $item->flag ?>" alt="<?= $item->name ?>" /><?php endif; ?><span><?= $item->name ?></span><?= $minPrice >0 ? "<div class=\"displayInline label-danger\">от <b>".$minPrice."</b></div>" : "" ?>
            <div class="floatRight"><?= $countItems >0 ? "всего <b>".$countItems."</b> предложений(ия)" : "" ?></div>
        </div>
        <div class="panel-body">
            <div class="ListTours2">
                <?php foreach( CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "active=1 AND is_newyear=1 AND country_id=:cid" )->setParams( [":cid"=>$item->id ] )->setOrderBy( "rating DESC, price" )->setLimit(10)->setCache(0) ) as $tour ) :

                        if( !$tour->image )
                        {
                            $imageList = CatGallery::fetchAll(DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_tours' AND item_id='" . $tour->id . "'")->setLimit(1)->setCache(0));
                            if( sizeof( $imageList ) >0 )
                                $tour->image = $imageList[0]->image;
                        }
                    ?>
                    <div class="LTItem2">
                        <div class="LTHover2"><a href="<?= SiteHelper::createUrl("/tours/description" )."/".$tour->slug.".html" ?>" title="<?= $tour->name ?>"><?= $tour->name ?></a></div>
                        <div class="LTImag2">
                            <?php if( $tour->image ) : ?>
                                <a href="<?= SiteHelper::createUrl("/tours/description" )."/".$tour->slug.".html" ?>" title="<?= $tour->name ?>"><img src="<?= ImageHelper::getImage( $tour->image, 2 ) ?>" alt="<?= $tour->name ?>" /></a>
                            <?php endif; ?>
                        </div>
                        <?php if( $tour->price > 0 ) : ?><div class="LTPrice2">от <b><?= $tour->price ?>$</b>&nbsp;</div><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a class="btn btn-success" href="<?= SiteHelper::createUrl( "tours/country" )."/status/newYear/".$item->slug.".html" ?>" title="смотреть все новогодние туры <?= $item->name_2 ?>">смотреть все новогодние туры <?= $item->name_2 ?> >>></a>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php if( sizeof($country) == 0 ) : ?>
    <div class="panel panel-warning">
        <div class="panel-heading"><b>Внимание!!! Вы можете стать первым</b></div>
        <div class="panel-body">
            Добавьте прямо сейчас новогоднее предложение. И Вы сможете стать первым, именно Ваши новогодние туры будут первыми в данном разделе.
        </div>
    </div>
<?php endif; ?>
<?php if( Yii::app()->user->isGuest ) : ?>
    <div class="panel panel-default">
        <div class="panel-heading"><b>Новый туристический год уже стучится в двери и надо успеть вовремя её открыть</b></div>
        <div class="panel-body">
            Новогодние праздники не за горами, а это значит, что уже сейчас необходимо задуматься о том, как помочь любителям путешествий с их организацией. Как это сделать?  Да просто надо как можно быстрей начать размещать на нашем сайте свои предложения по организации празднования Нового года. А мы постараемся оперативно донести их до потенциальных потребителей.<br/>
            Чтобы помочь вам в этом мы решили запустить на нашем портале раздел НОВОГОДНИЕ ПРЕДЛОЖЕНИЯ. Все поступающие в него предложения будут рекламироваться на нашем сайте, а также с помощью рассылок и социальных сетей.<br/>
        </div>
    </div>
<?php endif; ?>

<SCRIPT type="text/javascript">
    // Количество снежинок на странице (Ставьте в границах 30-40, больше не рекомендую)
    var snowmax=40;

    // Установите цвет снега, добавьте столько цветов сколько пожелаете
    var snowcolor=new Array("#AAAACC","#DDDDFF","#CCCCDD","#F3F3F3","#F0FFFF","#FFFFFF","#EFF5FF")

    // Поставьте шрифты из которых будет создана снежинка ставьте столько шрифтом сколько хотите
    var snowtype=new Array("Arial Black","Arial Narrow","Times","Comic Sans MS");

    // Символ из какого будут сделаны снежинки (по умолчанию * )
    var snowletter="*";

    // Скорость падения снега (рекомендую в границах от 0.3 до 2)
    var sinkspeed=0.8;

    // Максимальный размер снежинки
    var snowmaxsize=32;

    // Установите минимальный размер снежинки
    var snowminsize=15;

    // Устанавливаем положение снега
    // Впишите 1 чтобы снег был по всему сайту, 2 только слева
    // 3 только по центру, 4 снег справа
    var snowingzone=1;


    /*
     //   * ПОСЛЕ ЭТОЙ ФРАЗЫ БОЛЬШЕ НЕТ КОНФИГУРАЦИИ*
     */

    // НИЧЕГО НЕ ИЗМЕНЯТЬ

    var snow=new Array();
    var marginbottom;
    var marginright;
    var timer;
    var i_snow=0;
    var x_mv=new Array();
    var crds=new Array();
    var lftrght=new Array();
    var browserinfos=navigator.userAgent;
    var ie5=document.all&&document.getElementById&&!browserinfos.match(/Opera/);
    var ns6=document.getElementById&&!document.all;
    var opera=browserinfos.match(/Opera/);
    var browserok=ie5||ns6||opera;
    function randommaker(range) {
        rand=Math.floor(range*Math.random());
        return rand;
    }
    function initsnow() {
        if (ie5 || opera) {
            marginbottom=document.body.clientHeight;
            marginright=document.body.clientWidth;
        }
        else if (ns6) {
            marginbottom=window.innerHeight;
            marginright=window.innerWidth;
        }
        var snowsizerange=snowmaxsize-snowminsize;
        for (i=0;i<=snowmax;i++) {
            crds[i]=0;
            lftrght[i]=Math.random()*15;
            x_mv[i]=0.03+Math.random()/10;
            snow[i]=document.getElementById("s"+i);
            snow[i].style.fontFamily=snowtype[randommaker(snowtype/length)];
            snow[i].size=randommaker(snowsizerange)+snowminsize;
            snow[i].style.fontSize=snow[i].size+"px";
            snow[i].style.color=snowcolor[randommaker(snowcolor.length)];
            snow[i].sink=sinkspeed*snow[i].size/5;
            if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
            if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
            if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
            if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
            snow[i].posy=randommaker(2*marginbottom-marginbottom-2*snow[i].size);
            snow[i].style.left=snow[i].posx+"px";
            snow[i].style.top=snow[i].posy+"px";
        }
        movesnow();
    }
    function movesnow() {
        for(i=0;i<=snowmax;i++) {
            crds[i]+=x_mv[i];
            snow[i].posy+=snow[i].sink;
            snow[i].style.left=snow[i].posx+lftrght[i]*Math.sin(crds[i])+"px";
            snow[i].style.top=snow[i].posy+"px";
            if (snow[i].posy>=marginbottom-2*snow[i].size || parseInt(snow[i].style.left)>(marginright-3*lftrght[i])) {
                if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
                if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
                if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
                if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
                snow[i].posy=0;
            }
        }
        var timer=setTimeout("movesnow()",50);
    }
    for (i=0;i<=snowmax;i++) {
        document.write("<span id='s"+i+"' style='position:absolute;top:-"+snowmaxsize+"px;'>"+snowletter+"</span>");
    }
    if (browserok) {
        window.onload=initsnow;
    }
</SCRIPT>
<p><font face="arial, helvetica" size="-2"><a href="http://syblog.ru/">Снег Powered by Syblog</a></font></p>
