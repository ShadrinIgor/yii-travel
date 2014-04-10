<h2>Дополнительные услуги</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="">Фото</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php

    foreach( $items as $service ): ?>
        <tr <?= $service->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $service->id ?></td>
            <td>
                <?= ImageHelper::getAnimateImageBlock( $service, SiteHelper::createUrl("/service/description", array("id"=>$service->id, "fid"=>$item->id)), "услуга компании ". $service->name ) ?>
            </td>
            <td class="textAlignJustify">
                <a href="<?= SiteHelper::createUrl("/service/description", array("id"=>$service->id, "fid"=>$item->id)) ?>" title="услуга компании <?= $service->name ?>"><?= $service->name ?></a><br/>
                <?= SiteHelper::getSubTextOnWorld( $service->description, 400 ) ?>
                <div class="itemAction textAlignRight">
                    <a href="<?= SiteHelper::createUrl( "/service/description" )."/".$service->slug ?>.html" title="<?= $service->name ?> - услгу компании <?= $service->firm_id->name ?>">Описание</a><br/>
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