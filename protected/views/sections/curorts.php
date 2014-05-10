<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="">Фото</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php

    foreach( $items as $firmItem ):
        ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/resorts/description" )."/".$firmItem->slug.".html") ?>
            </td>            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/resorts/description")."/".$firmItem->slug ?>.html" title="описание туристического предложения"><?= $firmItem->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 300 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl("/resorts/category")."/".$firmItem->category_id->slug ?>.html"><?= $firmItem->category_id->name ?></a><br/>
                    <a href="<?= SiteHelper::createUrl("/resorts/description")."/".$firmItem->slug ?>.html">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" align="center">
            <?php
            $this->widget( "paginatorWidget", array( "count"=>$curortsCount, "page"=>$page, "offset"=>$offset, "url"=>"&action=c" ) );

            ?>
            <br/>
        </td>
    </tr>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="2" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>