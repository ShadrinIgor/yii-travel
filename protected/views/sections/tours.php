<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="">Фото</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php

    foreach( $tours as $firmItem ):
        ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/tours/description" )."/".$firmItem->slug.".html") ?>
            </td>
            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/tours/description")."/".$firmItem->slug ?>.html" title="описание туристического предложения"><?= $firmItem->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 300 ) ?>
                <div class="itemAction textAlignRight">
                    <?php if( $firmItem->country_id->id > 0 ) : ?><a href="<?= SiteHelper::createUrl("/tours/country")."/".$firmItem->country_id->slug ?>.html"><?= $firmItem->country_id->name ?></a><br/><?php endif; ?>
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