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
        <a href="#" id="s_tours" class="<?= $activeTab == "s_tours" ? "activeDM " : "" ?>dopMenuPages">Туры (<?= $tourCount ?>)</a>
        <a href="#" id="s_info" class="<?= $activeTab == "s_info" ? "activeDM " : "" ?>dopMenuPages">Информация (<?= sizeof( $info ) ?>)</a>
        <a href="#" id="s_curorts" class="<?= $activeTab == "s_curorts" ? "activeDM " : "" ?>dopMenuPages">Курорты/соны отдаха (<?= sizeof( $curorts ) ?>)</a>
    </div>
    <div id="s_tours_page" class="pageTab<?= $activeTab == "s_tours" ? " activePage " : " displayNone" ?>">
        <?php $this->renderPartial( "tours", array( "item"=>$item, "tours"=>$tours, "tourCount"=>$tourCount, "offset"=>$offset, "page"=>$t_page ) ) ?>
    </div>
    <div id="s_info_page" class="pageTab<?= $activeTab == "s_info" ? " activePage " : " displayNone" ?>">
        66
    </div>
    <div id="s_curorts_page" class="pageTab<?= $activeTab == "s_curorts" ? " activePage " : " displayNone" ?>">
        777
    </div>
</div>