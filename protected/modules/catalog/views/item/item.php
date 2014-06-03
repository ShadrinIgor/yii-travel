<?php

$this->widget('addressLineWidget', array(
    'links'=>array(
        $item->category_id->name=>SiteHelper::createUrl("/catalog/default/index", array("cid"=>$item->category_id)),
        $item->name
    ),
));

?>
<div id="catalogItems">
    <div class="CItem">
        <h1><?= $item->name ?></h1>
        <br/>
        <div class="overflowHidden">
            <?php if( $item->image ) : ?><div class="BIImage Ibig"><img src="<?= ImageHelper::getImage( $item->image, 2 ); ?>" /></div><?php endif; ?>
            <div class="overflowHidden">
                <div class="overflowHidden">
                    <div class="floatRight ItemPrice"><?php if( $item->price>0 ) : ?>Цена: <b><?= $item->price ?></b> <font>тг.</font><?php endif; ?></div>
                    <div class="floatRight ItemDate"><?php if( $item->date>0 ) : ?><?= Yii::t("user", "Дата") ?> : <?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?><?php endif; ?></div>
                    <?php if( !Yii::app()->user->isGuest ) : ?>
                        <div class="floatRight ItemFavorites">
                            <?php if( !Yii::app()->favorites->checkExists( $item->id, "catalog_items" ) ) : ?>
                                <a href="<?= SiteHelper::createUrl("/catalog/item/index", array( "id"=>$item->id, "favorites"=>"add" )) ?>">добавить в избранное в личном кабинете</a>
                            <?php else : ?>
                                добавлен в избранное в личном кабинете
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div id="userData">
                    <div id="UName"><?= $item->user_id->name ?></div>
                    <div class="UParams">Email: <b><a href="#" onclick="$(this).load('<?= SiteHelper::createUrl("/catalog/default/getUserInfo") ?>', { id :<?=$item->user_id->id ?>, field : 'email' }); return false;">показать Email</a></b></div>
                    <?php if( $item->user_id->phone ) : ?><div class="UParams">Телефон: <b><a href="#" onclick="$(this).load('<?= SiteHelper::createUrl("/catalog/default/getUserInfo") ?>', { id :<?=$item->user_id->id ?>, field : 'phone' }); return false;">показать телефон</a></b></div><?php endif; ?>
                    <?php if( $item->user_id->site ) : ?><div class="UParams">Сайт: <b><?= $item->user_id->site ?></b></div><?php endif; ?>
                    <?php if( $item->user_id->country && $item->user_id->country->id >0 ) : ?><div class="UParams"><?= Yii::t("page", "Страна"); ?>: <b><?= $item->user_id->country->name ?></b></div><?php endif; ?>
                    <?php if( $item->user_id->city && $item->user_id->city->id >0 ) : ?><div class="UParams">Город: <b><?= $item->user_id->city->name ?></b></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div id="itemDecription">
            <?php
            if( $item->param ) : ?>
                <div class="floatLeft paramData">
                    <h3>Параметры</h3>
                    <?php foreach( $item->getListProperty() as $key=>$value ) : ?>
                    <div class="overflowHidden">
                        <div class="UParams UPLeft"><?= $key ?>:</div>
                        <div class="UPValues">
                            <?php if( !is_array( $value ) ) : ?>
                                <b><?= $value ?></b>
                            <?php else : ?>
                                <ul>
                                <?php foreach( $value as $vItem ) : ?>
                                    <li><b><?= $vItem->name ?></b></li>
                                <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="overflowHidden">
                <?= $item->description ?>
                <?php
                    $images = ImageHelper::getImages( $item );
                    if( is_array( $images ) ):
                        echo '<div id="listImages">';
                        foreach( $images as $image ) :
                ?>
                        <div><a href="<?= $image->image ?>" rel="lightbox-group"><img src="<?= ImageHelper::getImage( $image->image, 2 ) ?>" alt="<?= $image->name ?>" /></a></div>
                <?php
                        endforeach;
                        echo "</div>";
                    endif;
                ?>
            </div>
        </div>
    </div>
    <div id="coments">
        <h3><?= Yii::t("user", "Коментарии") ?></h3>
        <?php foreach( $listComments as $item ) : ?>
            <div class="CItems">
                <div class="CIHeader">
                    <div class="floatLeft"><b><?= $item->subject ?></b></div>
                    <div class="floatRight"><?= SiteHelper::getDateOnFormat( $item->date, "d.m.Y" ) ?></div>
                </div>
                <?= $item->description ?>
            </div>
        <?php endforeach; ?>
        <div class="textAlignCenter"><input type="button" class="openDisplayNone" value="Оставить комментарий" /></div>
        <div class="<?php if( empty( $_POST["sentComment"] ) ) :?>displayNone <?php endif; ?>addForm">
            <?php if( !Yii::app()->user->isGuest ) : ?>
                <?= $addForm->getMessage(); ?>
                <?php if( !$addForm->formMessage ) : ?>
                    <?php echo CHtml::errorSummary($addForm); ?><br>
                    <form action="" method="post">
                        <table>
                            <?= CCModelHelper::addForm( $addForm ); ?>
                            <tr>
                                <td colspan="2" class="textAlignCenter">
                                    <?= CHtml::submitButton( "Отправить", array("name"=>"sentComment") ) ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                <?php endif; ?>
            <?php else : ?>
                <p class="textAlignCenter">Для отправки коментария необходимо авторизоваться</p>
                <?php $this->widget("authWidget") ?>
            <?php endif; ?>
        </div>
    </div>
    <div id="itemBlock">
        <div class="overflowHidden">
            <div class="blockName">Похожие объявления</div>
            <?php foreach( $otherItem as $item) : ?>
                <div class="IBItem">
                    <div class="BIImage<?php if( !$item->image ) : ?> noImage<?php endif; ?>"><?php if( $item->image ) : ?><img src="<?= ImageHelper::getImage( $item->image, 2 ); ?>" /><?php endif; ?></div>
                    <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
                    <?php if( $item->price>0 ) : ?><div class="IBPrice"><div class="IBPrice2"><b><?= $item->price ?></b> <font>тг.</font><div class="itemRightBG"></div></div></div><?php endif; ?>
                    <?= SiteHelper::getSubTextOnWorld( $item->description, 140 ) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <br/>
        <div class="overflowHidden">
            <div class="blockName">Горячие предложения</div>
            <?php foreach( $hotItem as $item) : ?>
                <div class="IBItem">
                    <div class="BIImage<?php if( !$item->image ) : ?> noImage<?php endif; ?>"><?php if( $item->image ) : ?><img src="<?= ImageHelper::getImage( $item->image, 2 ); ?>" /><?php endif; ?></div>
                    <a href="<?= SiteHelper::createUrl("/catalog/item/index", array("id"=>$item->id)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a><br/>
                    <?php if( $item->price>0 ) : ?><div class="IBPrice"><div class="IBPrice2"><b><?= $item->price ?></b> <font>тг.</font><div class="itemRightBG"></div></div></div><?php endif; ?>
                    <?= SiteHelper::getSubTextOnWorld( $item->description, 140 ) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>