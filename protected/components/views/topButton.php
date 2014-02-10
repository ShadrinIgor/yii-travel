<?php if( $type == "add_hotel_big" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/hotels" title="Добавить отель гостинуцу бесплатно">
            <b>Вы работает в Отеле? Хотите разместить рекламу БЕСПЛАТНО ?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить инфомацию о Вашей отеле, цены, фотографии, дополнительных услугах<br/>
            Например: Ваши услуги, рекламный баннер, спец предложениея, акции, скидки...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/hotels" title="Добавить отель гостинуцу бесплатно">
            <b>Хотите добавить Ваш отель?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить инфомацию о отеле<br/>
            Ваши услуги, рекламный баннер, акции...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_confirm" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="Подтвердить информацию о отеле гостинуци бесплатно">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Вы работаете в этом отеле?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br/>
            Хотите изменить/добавить информацию о отеле?<br/>
            Вы можете БЕСПЛАТНО вносить изминения
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_firm_dig" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/travel-agency" title="Добавить туристическую фиру, бесплатная реклама ">
            <b>Вы работает в туристической фирме? Хотите разместить рекламу БЕСПЛАТНО ?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить инфомацию о Вашей туристической фирме, о вашем отеле, зоне отдыха <br/>
            Например: Ваши услуги, рекламный баннер, туры, спец предложениея, акции...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_firm_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/travel-agency" title="Добавить туристическую фиру, бесплатная реклама ">
            <b>Хотите добавить Вашу фирму?</b>
            <br>
            вы можете БЕСПЛАТНО добавить инфомацию о тур. фирме<br>
            Ваши услуги, рекламный баннер, акции...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "confirm_firm_small" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add/confirm") ?>" title="Подтвердить информацию">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Вы работаете в этой тур. фирме?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br>
            Хотите изменить/добавить информацию тура<br>
            Вы можете БЕСПЛАТНО вносить изминения
        </a>
    </div>
<?php endif; ?>