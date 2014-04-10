<br/>
<?php
    SiteHelper::renderDinamicPartial( "pageTop" );
?>
<h1><?= $title ?></h1>
<?php if( !empty( $sectionTextSlug ) ) : ?>
    <?= SiteHelper::getAnimateText( $sectionTextSlug ) ?>
<?php endif; ?>
<div id="CIHeader" class="overflowHidden">
    <?php if( is_array( $arrSearchFields ) && sizeof($arrSearchFields)>0 ) : ?>
        <div id="CIFind">
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
                    <input type="submit" name="find" value="Найти" />
                </div>
            </form>
        </div>
        <div class="ParamsClear textAlignRight">
            <a href="<?= SiteHelper::createUrl($url."/index", array("params"=>"empty")) ?>" class="cMore" title="Сбросить критерии">[ Сбросить критерии ]</a>
        </div>
    <?php endif; ?>
    <?php if( !empty( $sort ) && sizeof( $sort )>0 ) : ?>
        <div id="CISort">
            <br/>
            <div class="displayInlainBlock">Сортировка:&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="displayInlainBlock">
                <?php
                $n=0;
                foreach( $sort as $item ) :
                    $n++;
                    ?>
                    <a class="CIH CIH<?= $by ?><?= $sortField == $item[0] ? " CIHActive" : "" ?>" href="<?= ( $sortField == $item[0] && $by == "desc" ) ? SiteHelper::createUrl($url."/", array("sort"=>$item[0], "by"=>"asc")) : SiteHelper::createUrl($url."/", array("sort"=>$item[0], "by"=>"desc")) ?>" title="отсортировать по <?= $item[1] ?>">по <?= $item[1] ?></a>&nbsp;
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $items ?>
<?php
$count = $catalog::sql( "SELECT count(id) as count_ FROM ".$tableModel->tableName()." WHERE ".$SQLParams );
$this->widget( "paginatorWidget", array( "count"=>$count[0]["count_"], "page"=>$page, "offset"=>$offset ) )
?>