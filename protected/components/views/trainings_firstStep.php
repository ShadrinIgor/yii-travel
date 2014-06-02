<h2><?= Yii::t("page", "Помощник по сайту"); ?></h2>
<form action="#" method="post" onsubmit="return trainingSave()">
    <div class="textAlignLeft">
        <div class="TFHeader"><?= Yii::t("page", "Укажите пожалуйста, вид деятельности Вашей компании"); ?>:</div>
        <div class="RFType">
            <input type="radio" name="CatalogTraining[user_type]" checked="checked" value="1" id="type1"><label for="type1"><?= Yii::t("page", "Туристическое агентство"); ?></label>
        </div>
        <div class="RFType">
            <input type="radio" name="CatalogTraining[user_type]" value="4" id="type4"><label for="type4"><?= Yii::t("page", "Отель"); ?></label>
        </div>
        <div class="RFType">
            <input type="radio" name="CatalogTraining[user_type]" value="5" id="type5"><label for="type5"><?= Yii::t("page", "Зона отдыха, Курорт"); ?></label>
        </div>
        <div class="RFType">
            <input type="radio" name="CatalogTraining[user_type]" value="5" id="type6"><label for="type6"><?= Yii::t("page", "Детский лагерь"); ?></label>
        </div>
        <div class="RFType">
            <input type="radio" name="CatalogTraining[user_type]" value="3" id="type3"><label for="type3"><?= Yii::t("page", "Другое"); ?></label>
        </div>
        <div>
            <input type="submit" name="nextSession" value="<?= Yii::t("page", "Далее"); ?>" />
        </div>
    </div>
</form>
<br/>
<div class="textAlignCenter">
    <a href="#" class="trainingsClose"><?= Yii::t("page", "Закрыть подсказку"); ?></a>&nbsp;|&nbsp;
    <a href="#" class="trainingsCloseGroup"><?= Yii::t("page", "Больше не напоминать"); ?></a>
</div>
