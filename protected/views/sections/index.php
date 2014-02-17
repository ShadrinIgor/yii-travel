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
        <a href="#" id="s_tours" class="<?= $activeTab == "s_tours" ? "activeDM " : "" ?>dopMenuPages">Туры (<?= sizeof( $tours ) ?>)</a>
        <a href="#" id="s_info" class="<?= $activeTab == "s_info" ? "activeDM " : "" ?>dopMenuPages">Информация (<?= sizeof( $info ) ?>)</a>
        <a href="#" id="s_curorts" class="<?= $activeTab == "s_curorts" ? "activeDM " : "" ?>dopMenuPages">Курорты/соны отдаха (<?= sizeof( $curorts ) ?>)</a>
    </div>
    <div id="s_tours_page" class="pageTab<?= $activeTab == "s_tours" ? " activePage " : " displayNone" ?>">
        <table id="tableListItems" cellpadding="0" cellspacing="0">
            <tr>
                <th class="TLFId">№</th>
                <th class="">Фото</th>
                <th class="TLFName">Заголовок</th>
                <th class="TLFAction">Краткое описание</th>
            </tr>
            <?php

            foreach( $tours as $firmItem ): ?>
                <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
                    <td><?= $firmItem->id ?></td>
                    <td>
                        <?php
                        if( !$firmItem->image )$countImages = 5;
                        else $countImages = 4;

                        $listImages = ImageHelper::getImages( $firmItem, $countImages );
                        if( sizeof( $listImages ) >0 || $firmItem->image ) : ?>
                            <div class="listItemsImages">
                                <?php if( $firmItem->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $firmItem->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                                <?php
                                if( $firmItem->image )$i=2;
                                else $i=1;
                                foreach( $listImages as $LItem ) : ?>
                                    <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                                    <?php $i++;endforeach; ?>
                            </div>
                        <?php endif;?>
                    </td>
                    <td>
                        <a href="<?= SiteHelper::createUrl("/touristInfo/").$firmItem->id."-".$firmItem->slug ?>" title="описание акции/скидки"><?= $firmItem->name ?></a>
                    </td>
                    <td class="textAlignJustify">
                        <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 400 ) ?>
                        <div class="itemAction textAlignRight">
                            <a href="<?= SiteHelper::createUrl("/touristInfo/").$firmItem->id."-".$firmItem->slug ?>">Описание</a><br/>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if( sizeof( $tours ) == 0 ) : ?>
                <tr>
                    <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <div id="s_info_page" class="pageTab<?= $activeTab == "s_info" ? " activePage " : " displayNone" ?>">
        66
    </div>
    <div id="s_curorts_page" class="pageTab<?= $activeTab == "s_curorts" ? " activePage " : " displayNone" ?>">
        777
    </div>
</div>