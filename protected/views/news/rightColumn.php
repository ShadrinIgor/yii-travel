<div id="Cleft">
    <?php $this->widget("authWidget"); ?>
    <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
    <div id="keywords">
        <?php Yii::app()->page->renderTags( "news" ) ?>
    </div>
</div>