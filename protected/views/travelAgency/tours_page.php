<div id="firmTours">
    <h2>Туры компании</h2>
    <table id="tableListItems" cellpadding="0" cellspacing="0">
        <tr>
            <th class="TLFId">№</th>
            <th class="">Фото</th>
            <th class="TLFName" style="width: 150px;">Заголовок</th>
            <th class="TLFAction">Краткое описание</th>
        </tr>
        <?php

        foreach( $items as $tour ): ?>
            <tr <?= $tour->hot==1 ? 'class="isHot"' : "" ?>>
                <td><?= $tour->id ?></td>
                <td>
                    <?php
                    if( !$tour->image )$countImages = 5;
                    else $countImages = 4;

                    $listImages = ImageHelper::getImages( $tour, $countImages );
                    if( sizeof( $listImages ) >0 || $tour->image ) : ?>
                        <div class="listItemsImages">
                            <?php if( $tour->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $tour->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                            <?php
                            if( $tour->image )$i=2;
                            else $i=1;
                            foreach( $listImages as $LItem ) : ?>
                                <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                                <?php $i++;endforeach; ?>
                        </div>
                    <?php endif;?>
                </td>
                <td>
                    <a href="<?= SiteHelper::createUrl("/tours/description", array("id"=>$tour->id, "slug"=>$tour->slug)) ?>.html" title="описание тура <?= $tour->name ?>"><?= $tour->name ?></a><br/>
                    <?= $tour->country_id->name." ".$tour->city_id->name ?>
                </td>
                <td class="textAlignJustify">
                    <?= SiteHelper::getSubTextOnWorld( $tour->description, 400 ) ?>
                    <div class="itemAction textAlignRight">
                        <a href="<?= SiteHelper::createUrl("/tours/description", array("id"=>$tour->id, "slug"=>$tour->slug)) ?>.html">смотреть подробнее...</a><br/>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if( sizeof( $items ) == 0 ) : ?>
            <tr>
                <td colspan="6" class="textAlignCenter emptyList">Список пуст</td>
            </tr>
        <?php endif; ?>
    </table>
</div>