<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        $item->name
    )
));
?>

<div id="InnerText">
    <h1><?= $item->name ?></h1>
    <p>
        <?= $item->description ?>
    </p>
    <div id="dopMenu">
        <?php if( $tourCount>0 ) : ?><a href="#" id="s_tours" class="<?= $activeTab == "s_tours" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("page", "Туры"); ?> (<?= $tourCount ?>)</a><?php endif; ?>
        <?php if( $detCount ==0 && $curortsCount>0 ) : ?><a href="#" id="s_curorts" class="<?= $activeTab == "s_curorts" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("page", "Зоны отдыха/Курорты"); ?> (<?= $curortsCount ?>)</a><?php endif; ?>
        <?php if( $detCount>0 ) : ?><a href="#" id="s_curorts" class="<?= $activeTab == "s_curorts" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("page", "Детские лагеря"); ?> (<?= $detCount ?>)</a><?php endif; ?>
        <?php if( $infoCount>0 ) : ?><a href="#" id="s_info" class="<?= $activeTab == "s_info" ? "activeDM " : "" ?>dopMenuPages"><?= Yii::t("page", "Информация"); ?> (<?= $infoCount ?>)</a><?php endif; ?>
    </div>
    <div id="s_tours_page" class="pageTab<?= $activeTab == "s_tours" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "tours", array( "item"=>$item, "country"=>$country, "category"=>$category, "toursSQL" =>$toursSQL, "tours"=>$tours, "tourCount"=>$tourCount, "offset"=>$offset, "page"=>$t_page ) ) ?>
    </div>
    <div id="s_info_page" class="pageTab<?= $activeTab == "s_info" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "info", array( "item"=>$item, "infoSQL"=>$infoSQL, "category"=>$icategory,  "items"=>$info, "infoCount"=>$infoCount, "offset"=>$offset, "page"=>$i_page ) ) ?>
    </div>
    <div id="s_curorts_page" class="pageTab<?= $activeTab == "s_curorts" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "curorts", array( "item"=>$item, "kurortsSQL"=>$kurortsSQL, "category"=>$ccategory,  "items"=>$curorts, "curortsCount"=>$curortsCount, "offset"=>$offset, "page"=>$c_page ) ) ?>
    </div>
    <?php $this->widget("socialLinksWidget", array( "id"=>"socialLinks") ) ?>
</div>