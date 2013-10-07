<?php
$cid = (int) Yii::app()->request->getParam( "cid", 0 );

if( !empty( $cid ) )
{
    $cidOwner = CatalogItemsCategory::fetch( $cid );
    $listCid = CatalogItemsCategory::findByAttributes(array("owner"=>$cidOwner->owner->id));
}
    else
{
    $cidOwner = CatalogItemsCategory::fetch( 1 );
    $listCid = CatalogItemsCategory::findByAttributes(array("owner"=>$cidOwner->id));
}


$itemModel = new CatalogItems();
?>

<div id="centerLeft">
        <?php if( $cidOwner->table_name ) : ?>
        <div class="titleLIneLeft" id="findParams">
            <form action="" method="post" />
                <div class="blockName">&nbsp;&nbsp;Поиск&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <br/>
            <div class="FPItem">
                <div class="FPITitle">Город</div>
                <div class="FPIInput"><?= CCmodelHelper::getInputField( $itemModel, "city_id" ) ?></div>
            </div>

            <div class="FPItem">
                        <div class="FPITitle">Категория</div>
                        <div class="FPIInput">
                            <select name="CatalogItems[category_id]">
                                <option value=""> --- --- --- </option>
                                <?php foreach( $listCid as $category ) :
                                    if( !empty( $cid ) && $cid==$category->id )$sel="selected";else $sel="";
                                    ?>
                                    <option value="<?= $category->id ?>" <?= $sel ?>><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="FPItem">
                        <div class="FPITitle">Тип объявления</div>
                        <div class="FPIInput">
                            <select name="CatalogItems[type_id]">
                                <option value=""> --- --- --- </option>
                                <?php foreach( CatalogItemsType::fetchAll() as $category ) :
                                    if( !empty( $_POST["CatalogItems"]["type_id"] ) && $_POST["CatalogItems"]["type_id"]==$category->id )$sel="selected";else $sel="";
                                    ?>
                                    <option value="<?= $category->id ?>" <?= $sel ?>><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="FPItem">
                        <div class="FPITitle">Цена</div>
                        <div class="FPIInput"><?= CCmodelHelper::getInputField( $itemModel, "price" ) ?></div>
                    </div>
            <?php

                    $tableClass = SiteHelper::getCamelCase( $cidOwner->table_name );
                    $tableModel = new $tableClass();
                    $i=0;

                    $arrSearcheFields = $tableModel->getSearchAttributes();
                    $attributeLabels = $tableModel->attributeLabels();
                    if( is_array( $arrSearcheFields ) && sizeof( $arrSearcheFields )>0 ) :

                    foreach( $arrSearcheFields as $key ) :
                        $key = trim( $key );
                    ?>
                    <div class="FPItem">
                        <div class="FPITitle"><?= !empty( $attributeLabels[$key] ) ? $attributeLabels[$key] : $key ?></div>
                        <div class="FPIInput<?= ( $i>5 && ( empty( $_POST[$tableClass][$key] ) && empty( $_POST[$tableClass][$key."_2"] )  ) ) ? " displayNone" : "" ?>"><?= CCmodelHelper::getInputField( $tableModel, $key ) ?></div>
                    </div>
                <?php $i++;endforeach;
                    endif;
                ?>
                <div class="FPItem">
                    <input type="submit" name="find" value="Найти" />
                </div>

            </form>
        </div>
        <?php endif; ?>

    <div id="itemCategory">
        <div class="blockName">категории</div>
        <ul>
        <?php foreach( CatalogItemsCategory::fetchAll(DBQueryParamsClass::CreateParams()->setConditions("owner=:cat AND id!=2")->setParams(array(":cat"=>0))->setOrderBy("name") ) as $item ) : ?>
            <li>
                <a href="#" class="BNcat" title="<?= $item->name ?>"><?= $item->name ?></a>
                <?php
                    $i=0;
                    foreach( CatalogItemsCategory::fetchAll(DBQueryParamsClass::CreateParams()->setConditions("owner=:cat")->setParams(array(":cat"=>$item->id))->setOrderBy("name") ) as $item2 ) :
                ?>
                    <?php if( $i==0 ) :?><ul <?php if( $cidOwner->owner!=$item->id ) :?>class="displayNone"<?php endif; ?>><?php endif; ?>
                    <li><a href="<?= SiteHelper::createUrl("/catalog/default/index", array("cid"=>$item2->id)) ?>" <?php if( $cid ==$item2->id ) :?>class="selectCategory"<?php endif; ?> title="<?= $item2->name ?>"><?= $item2->name ?></a></li>
                <?php $i=1;endforeach; ?>
                <?php if( $i==1 ) :?></ul><?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <div class="titleLIneLeft">
        <div class="blockName">&nbsp;&nbsp;Информация&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <br/>
        <?php
        $n=0;
        foreach( CatalogContent::fetchAll( DBQueryParamsClass::CreateParams()->setLimit( 6 )->setConditions("category_id=:category_id")->setParams(array(":category_id"=>2))->setOrderBy("id DESC") ) as $item ) : ?>
            <div class="NItem">
                <div class="NIFHeader"><a href="<?= SiteHelper::createUrl("/news/index", array("id"=>$item->id)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a> </div>
                <?php if( $n<5 ) : ?>
                    <?= SiteHelper::getSubTextOnWorld( $item->description, 100 ) ?>
                <?php endif; ?>
            </div>
            <?php $n++;endforeach; ?>
    </div>

</div>