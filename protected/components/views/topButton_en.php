<?php if( $type == "add_first" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>" title="Add a free tour. information recreation area, children's camp, information on the site">
            <b>Add information</b>
            <br/>
            their tours, the tour company, a relaxation area, <br/>
             resort area, private or other ad ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "confirm_first" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="confirm the information">
            <b>Confirm the information</b>
            <br/>
            Information about your company is already posted on the site? <br/>
            You can contribute traits, enhance information
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_resorts_big" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/curorts" title="Add a free relaxation area, children's camp">
            <b>You work in a recreation area or resort? Advertise FREE?</b>
            <br/>
            you may add your information of their recreation area or resort, prices, photos, extras <br/>
            For example: your services, banner advertising, special offers, promotions, discounts ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_resorts_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/curorts" title="Add a free relaxation area, children's camp">
            <b>Want to add your recreational area?</b>
            <br/>
            FREE you can add information about your resort <br/>
            services, banner advertising, promotions ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_resorts_confirm" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="Confirm the information and make changes for free">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Working in this recreation area?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br/>
            Want to change / add information about recreation? <br/>
            You can make FREE mutations both
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_big" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/hotels" title="Add hotel hotel free">
            <b>You work in a hotel? Want to advertise for FREE?</b>
            <br/>
            FREE you can add information about your hotel, prices, photos, extras <br/>
            For example: your services, banner advertising, special offers, promotions, discounts ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/hotels" title="Add hotel hotel free">
            <b>Want to add your hotel?</b>
            <br/>
            FREE you can add information about the hotel <br/>
            Your services, banner advertising, promotions ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_hotel_confirm" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add") ?>/confirm" title="Confirm the information at the hotel for free">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Do you work at this hotel?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br/>
            Want to change / add information about the hotel? <br/>
            You can make FREE mutations both
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_firm_dig" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/travel-agency" title="Add a travel agency, free advertising">
            <b>You work in a travel agency? Want to advertise for FREE?</b>
            <br/>
            you may add information about your travel company about your hotel, recreation area <br/>
            For example: your services, banner advertising, tours, special offers, promotions ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "add_firm_small" ) : ?>
    <div class="B01">
        <a href="<?= SiteHelper::createUrl("/add") ?>/travel-agency" title="Add a travel agency, free advertising ">
            <b>Want to add your company?</b>
            <br>
            FREE add information about the tour company <br>
            Your services, banner advertising, promotions ...
        </a>
    </div>
<?php endif; ?>
<?php if( $type == "confirm_firm_small" ) : ?>
    <div class="B02">
        <a href="<?= SiteHelper::createUrl("/add/confirm") ?>" title="Confirm the information">
            <b>You are running this tour company?</b>
            <br>
            Want to change / add information, tours <br>
            You can make FREE mutations both
        </a>
    </div>
<?php endif; ?>