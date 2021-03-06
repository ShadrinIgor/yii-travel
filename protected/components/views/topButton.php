<?php if( $type == "add_first" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>" title="Добавить бесплатно тур. информацию зону отдыха, детский лагерь, информацию на сайт">
            <b>Добавить информацию</b>
            <br/>
            свои туры, тур. фирму, зону отдыха,<br/>
            курортную зону, частные объявление или прочее...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "confirm_first" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="Подтвердить информацию">
            <b>Подтвердить информацию</b>
            <br/>
            Информация о Вашей компании уже размещена на сайте?<br/>
            Вы можете вносить изминения, добавлять информацию
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_resorts_big" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/curorts" title="Добавить бесплатно зону отдыха, детский лагерь">
            <b>Вы работаете в Зоне отдыха или Курорте? Разместить рекламу БЕСПЛАТНО?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить информацию о Вашей зоне отдыха или курорте, цены, фотографии, дополнительные услуги<br/>
            Например: Ваши услуги, рекламный баннер, спец предложения, акции, скидки...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_resorts_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/curorts" title="Добавить бесплатно зону отдыха, детский лагерь">
            <b>Хотите добавить Вашу зону отдыха?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить информацию о курорте<br/>
            Ваши услуги, рекламный баннер, акции...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_resorts_confirm" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="Подтвердить информацию и вносить изменения бесплатно">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Работаете в этой зоне отдыха?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br/>
            Хотите изменить/добавить информацию о зоне отдыха?<br/>
            Вы можете БЕСПЛАТНО вносить изминения
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_big" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/hotels" title="Добавить отель гостиницу бесплатно">
            <b>Вы работаете в Отеле? Хотите разместить рекламу БЕСПЛАТНО?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить информацию о Вашем отеле, цены, фотографии, дополнительные услуги<br/>
            Например: Ваши услуги, рекламный баннер, спец предложения, акции, скидки...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/hotels" title="Добавить отель гостиницу бесплатно">
            <b>Хотите добавить Ваш отель?</b>
            <br/>
            вы можете БЕСПЛАТНО добавить информацию о отеле<br/>
            Ваши услуги, рекламный баннер, акции...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_confirm" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="Подтвердить информацию о отеле гостинице бесплатно">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Вы работаете в этом отеле?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br/>
            Хотите изменить/добавить информацию о отеле?<br/>
            Вы можете БЕСПЛАТНО вносить изминения
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_firm_dig" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/travel-agency" title="Добавить туристическую фирму, бесплатная реклама ">
            <b>Вы работает в туристической фирме? Хотите разместить рекламу БЕСПЛАТНО ?</b>
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_firm_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/travel-agency" title="Добавить туристическую фирму, бесплатная реклама ">
            <b>Хотите добавить Вашу фирму?</b>
            <br>
            добавить БЕСПЛАТНО информацию о тур. фирме<br>
            Ваши услуги, рекламный баннер, акции...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "confirm_firm_small" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add/confirm") ?>" title="Подтвердить информацию">
            <b>Вы работаете в этой тур. фирме?</b>
            <br>
            Хотите изменить/добавить информацию, туры<br>
            Вы можете БЕСПЛАТНО вносить изминения
        </a>
    </div>
<?php endif; ?>