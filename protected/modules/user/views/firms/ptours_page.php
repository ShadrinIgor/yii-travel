<div id="firmTours">
    <h2>Туры компании</h2>
    <table id="tableListItems" cellpadding="0" cellspacing="0">
        <tr>
            <th class="TLFId">№</th>
            <th class="">Фото</th>
            <th class="TLFName">Заголовок</th>
            <th class="TLFType">Страна</th>
            <th>Статус</th>
            <th>Просмотров</th>
            <th class="TLFAction">Действия</th>
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
                    <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id)) ?>" title="описание"><?= $tour->name ?></a>
                </td>
                <td><?= $tour->country_id->name.", ".$tour->city_id->name ?></td>
                <td class="textAlignCenter publishStatus"><?= ( $tour->active == 1 ) ? "опубликовано" : "не опубликовано" ?></td>
                <td class="textAlignCenter"><?= $tour->col ?></td>
                <td class="textAlignCenter">
                    <a href="#" class="aAction"></a>
                    <div class="itemAction textAlignCenter">
                        <a href="<?= SiteHelper::createUrl("/user/tours/description", array("id"=>$tour->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                        <div>
                            <?php if( $tour->active == 1 ) : ?>
                                <a href="#" class="publishLink" onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$tour->id, "catalog"=>"CatalogTours")) ?>', '' );">Снять с публикации</a><br/>
                            <?php else : ?>
                                <a href="#" class="publishLink"  onclick="return ajaxAction( this, '<?= SiteHelper::createUrl("/user/firms/setPublish", array("id"=>$tour->id, "catalog"=>"CatalogTours")) ?>', '' );">Опубликовать</a><br/>
                            <?php endif; ?>
                        </div>

                        <div class="popup PMarginLeft">
                            <br/>
                            <b>Вы действительно хотите удалить запись?</b>
                            <br/><br/>
                            <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                            <a href="#"  onclick="return ajaxDeleteAction( this, '<?= SiteHelper::createUrl("/user/firms/delete", array("id"=>$tour->id, "catalog"=>"CatalogTours")) ?>', '' );" class="deleteItem">Удалить</a>
                        </div>
                        <a href="#" class="PDel">Удалить</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if( sizeof( $items ) == 0 ) : ?>
            <tr>
                <td colspan="7" class="textAlignCenter emptyList">Список пуст</td>
            </tr>
        <?php endif; ?>
        <tr>
            <td colspan="7" class="textAlignCenter emptyList"><br/><a href="<?= SiteHelper::createUrl("/user/tours/description", array("fid"=>$item->id)) ?>">[ добавить новый тур ]</a><br/></td>
        </tr>
    </table>
</div>