<div class="leftBlock">
    <?php $this->widget("authWidget"); ?>
    <?php $this->widget("findFormWidget") ?>
    <div id="LeftBG">
        <?php $this->widget("infoWidget", array( "title"=>Yii::t("page", "Информация туристу"), "class"=>"CatalogInfo", "link"=>"/touristInfo" )); ?>
    </div>
</div>