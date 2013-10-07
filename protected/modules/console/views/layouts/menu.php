<?php if( !Yii::app()->user->isGuest ) : ?>
<div id="Header">
    <div id="menu">
        <ul>
            <?php foreach( Yii::app()->params['catalogList'] as $item ) :
                if( !empty( $item["params"] ) )$item["params"] = "?".$item["params"];
                ?>
                <?php if( empty( $item["items"] ) ) : ?>
                    <li><a href="<?= SiteHelper::createUrl( "/console/".$item["controller"] )."/".$item["params"] ?>"><?= $item["title"] ?></a></li>
                <?php else : ?>
                    <li class="subMenu">
                        <a href="#"><?= $item["title"] ?></a>
                        <div class="displayNone">
                            <ul>
                                <?php foreach( $item["items"] as $item2 ) :
                                        if( !empty( $item2["params"] ) )$item2["params"] = "?".$item2["params"];
                                ?>
                                    <li><a href="<?= SiteHelper::createUrl( "/console/".$item2["controller"] )."/".$item2["params"] ?>"><?= $item2["title"] ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach;?>
                <li class="subMenu MProperties">
                    <a href="#">Параметры</a>
                    <div class="displayNone">
                        <ul>
                            <li><a href="<?= SiteHelper::createUrl("/console/banners") ?>">Банеры</a></li>
                            <li><a href="#">Настройки</a></li>
                        </ul>
                    </div>
                </li>
        </ul>
    </div>
    <div id="HRight">
        <a href="<?= SiteHelper::createUrl( "/console/default/logout" ) ?>">Выйти</a></li>
    </div>
</div>
<?php endif; ?>
