<div id="<?= $id ?>" class="SC">
    <div>
    <font><?= Yii::t("page", "Поделитесь находкой") ?>:</font>
    <noindex>
        <ul>
            <li id="CB_01"><a onclick="yaCounter6154003.reachGoal('shared_button');return new_window('http://vkontakte.ru/share.php?url=<?= $url ?>',600,400);" href="#"></a></li>
            <li id="CB_02"><a onclick="yaCounter6154003.reachGoal('shared_button');return new_window('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=<?= $url ?>',600,400);" href="#"></a></li>
            <li id="CB_03"><a onclick="yaCounter6154003.reachGoal('shared_button');return new_window('http://www.facebook.com/sharer.php?u=<?= $url ?>',600,400);" href="#"></a></li>
            <li id="CB_04"><a onclick="yaCounter6154003.reachGoal('shared_button');return new_window('http://connect.mail.ru/share?url=<?= $url ?>',600,400);" href="#" class="mrc__plugin_like_button"></a></li>
            <li id="CB_05"><a onclick="yaCounter6154003.reachGoal('shared_button');return new_window('http://twitter.com/share?url=<?= $url ?>',600,400);" href="#"></a></li>
            <li id="CB_06"><a href="#" onclick="yaCounter6154003.reachGoal('shared_button');return new_window('http://www.livejournal.com/update.bml?event=<?= $url ?>',800,600);"></a></li>
            <li><script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script><fb:like href="<?= $url ?>" layout="button_count" show_faces="false" width="200" font="lucida grande"></fb:like></li>
        </ul>
    </noindex>
    </div>
</div>