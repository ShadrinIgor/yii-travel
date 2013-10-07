<?php

$listNews = CatalogCid::fetchAll( DBQueryParamsClass::CreateParams()->setLimit( -1 ) );
foreach( $listNews as $values ) : ?>
    <div><a href="<?= SiteHelper::createUrl("category/", array( "slug"=>$values->key_word )) ?>" title="<?= SiteHelper::getStringForTitle( $values->name ) ?> : Мировые новости, новости Узбекистана"><?= $values->name; ?></a></div>
    <div class="M_sep"></div>
<?php endforeach; ?>