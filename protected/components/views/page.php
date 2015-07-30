<?php if( $showFindForm ) : ?>
    <br/>
    <?php
        SiteHelper::renderDinamicPartial( "pageTop" );
    ?>
    <h1><?= $title ?></h1>
    <?php if( !empty( $sectionTextSlug ) ) : ?>
        <?= SiteHelper::getAnimateText( $sectionTextSlug ) ?>
    <?php endif; ?>
    <?php if( !empty( $addUrl ) ) : ?>
        <div class="textAlignCenter"><a href="<?= $addUrl ?>" class="addButton" title="<?= $linkName ?>"><?= $linkName ?></a></div>
    <?php endif; ?>

    <div id="CIHeader" class="overflowHidden">
        <?php if( Yii::app()->controller->getId() == "tours" ) : ?>
            <div id="CIFind" class="panel panel-success panel-open">
                <div class="panel-heading">ИСКАТЬ ТУРЫ ПО СТРАННАМ&nbsp;<img src="themes/classic/images/menu_bg3.png" /></div>
                <div class="panel-body panel-display-block">
                    <?php if( $this->beginCache( "tours_country_".Yii::app()->getLanguage(), array('duration'=>3600) ) ) : ?>
                        <ul class="TFCountry">
                            <?php
                            foreach( CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setOrderBy( "name" )->setLimit(-1) ) as $item ) :
                                $count = CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country")->setParams(array(":country"=>$item->id))->setLimit(-1) );
                                ?>
                                <li><img src="<?= $item->flag ?>"><a href="<?= SiteHelper::createUrl("/tours/country")."/".$item->slug ?>.html" title="<?= Yii::t("page", "туры"); ?> <?= $item->name_2 ?>"><?= $item->name ?> ( <?= $count ?> )</a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php $this->endCache(); endif;?>
                    <div class="ParamsClear textAlignRight">
                        <a class="label label-success" href="<?= SiteHelper::createUrl($url."/index", array("params"=>"empty")) ?>" class="cMore" title="<?= Yii::t("page", "Сбросить критерии"); ?>">Смотреть все туры</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if( is_array( $arrSearchFields ) && sizeof($arrSearchFields)>0 ) : ?>
            <div id="CIFind" class="panel panel-info panel-open">
                <div class="panel-heading"><?= $findTitle ?>&nbsp;<img src="themes/classic/images/menu_bg3.png" /></div>
                <div class="panel-body<?= !empty( $_POST["find"] ) ? " panel-display-block" : "" ?>">
                    <form action="<?= SiteHelper::createUrl($url."/") ?>" method="POST">
                        <?php foreach( $arrSearchFields as $key ) :
                            $key = trim( $key );
                            ?>
                            <div class="displayInlainBlock">
                                <?= !empty( $attributeLabels[$key] ) ? $attributeLabels[$key] : $key ?>:
                                <?= CCModelHelper::getInputField( $tableModel, $key ) ?>
                            </div>
                            <?php endforeach; ?>
                        <div class="displayInlainBlock">
                            <input type="submit" class="btn btn-info" name="find" value="<?= Yii::t("page", "Найти" ) ?>" />
                        </div>
                    </form>
                    <div class="ParamsClear textAlignRight">
                        <a class="label label-info" href="<?= SiteHelper::createUrl($url."/index", array("params"=>"empty")) ?>" class="cMore" title="<?= Yii::t("page", "Сбросить критерии"); ?>"><?= Yii::t("page", "Сбросить критерии"); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if( !empty( $sort ) && sizeof( $sort )>0 ) : ?>
            <div id="CISort">
                <br/>
                <div class="displayInlainBlock"><?= Yii::t("page", "Сортировка"); ?>:&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="displayInlainBlock">
                    <?php
                    $n=0;
                    foreach( $sort as $item ) :
                        $n++;
                        ?>
                        <a class="CIH CIH<?= $by ?><?= $sortField == $item[0] ? " CIHActive" : "" ?>" href="<?= ( $sortField == $item[0] && $by == "desc" ) ? SiteHelper::createUrl($url."/", array("sort"=>$item[0], "by"=>"asc")) : SiteHelper::createUrl($url."/", array("sort"=>$item[0], "by"=>"desc")) ?>" title="<?= Yii::t("page", "отсортировать по"); ?> <?= $item[1] ?>"><?= Yii::t("page", "по"); ?> <?= $item[1] ?></a>&nbsp;
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?= $items ?>
<?php
$count = $catalog::sql( "SELECT count(id) as count_ FROM ".$tableModel->tableName()." WHERE ".$SQLParams );
$this->widget( "paginatorWidget", array( "count"=>$count[0]["count_"], "page"=>$page, "offset"=>$offset ) )
?>