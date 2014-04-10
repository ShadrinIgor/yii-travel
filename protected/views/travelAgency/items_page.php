<h2>Акции/скидки компании</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFName">Заголовок</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php

    foreach( $items as $firmItem ): ?>
        <tr <?= $firmItem->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $firmItem->id ?></td>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $firmItem, SiteHelper::createUrl("/items/description")."/".$firmItem->slug .".html", "Описание акции/скидки ".$firmItem->name ) ?>
            </td>
            <td>
                <a href="<?= SiteHelper::createUrl("/items/description")."/".$firmItem->slug ?>.html" title="<?= $firmItem->name ?> акции/скидки от компании <?= $firmItem->firm_id->name ?>"><?= $firmItem->name ?></a>
            </td>
            <td class="textAlignJustify">
                <?= SiteHelper::getSubTextOnWorld( $firmItem->description, 400 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl("/items/description")."/".$firmItem->slug ?>.html" title="Описание акции/скидки <?= $firmItem->name ?>">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>