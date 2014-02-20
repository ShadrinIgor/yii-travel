<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php

    foreach( $tours as $firmItem ):
        ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $firmItem->id ?></td>
            <td>
                <div class="listItemsImages">
                    <?php
                    if( !$firmItem->image )$countImages = 5;
                    else $countImages = 4;

                    $listImages = ImageHelper::getImages( $firmItem, $countImages );
                    if( sizeof( $listImages ) >0 || $firmItem->image ) : ?>

                        <?php if( $firmItem->image ) : ?><div class="LII_1"><img src="<?= ImageHelper::getImage( $firmItem->image, 3 ) ?>" alt="" /></div><?php endif; ?>
                        <?php
                        if( $firmItem->image )$i=2;
                        else $i=1;
                        foreach( $listImages as $LItem ) : ?>
                            <div class="LII_<?= $i ?>"><img src="<?= ImageHelper::getImage( $LItem->image, 3 ) ?>" alt="" /></div>
                            <?php $i++;endforeach; ?>

                    <?php endif;?>
                </div>
            </td>
            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/tours/description")."/".$firmItem->slug ?>.html" title="описание туристического предложения"><?= $firmItem->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 300 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl("/tours/category")."/".$firmItem->category_id->slug ?>.html"><?= $firmItem->category_id->name ?></a><br/>
                    <a href="<?= SiteHelper::createUrl("/tours/description")."/".$firmItem->slug ?>.html">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" align="center">
            <?php
            $this->widget( "paginatorWidget", array( "count"=>$tourCount, "page"=>$page, "offset"=>$offset, "url"=>"&action=t" ) );

            ?>
            <br/>
        </td>
    </tr>
    <?php if( sizeof( $tours ) == 0 ) : ?>
        <tr>
            <td colspan="3" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>