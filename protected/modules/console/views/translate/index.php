<h1>Перевод</h1>

<form action="" method="post">
    <select name="lang">
        <option value="en" <?= $_POST["lang"] == "en" ? "selected" : "" ?>>En</option>
        <option value="ja" <?= $_POST["lang"] == "ja" ? "selected" : "" ?>>Ja</option>
        <option value="zh-TW" <?= $_POST["lang"] == "zh-TW" ? "selected" : "" ?>>Ch</option>
    </select>
<textarea rows="40" cols="120" class="mceNoEditor" name="text"><?= $text ?></textarea>
    <div class="textAlignCenter"><input type="submit" name="submit_text" value="Перевести"  /></div>
    <br/>
    Пример:
    <hr/>
        "Бесплатное добавление туристической информации на сайт" => "Free refills on tourist information site",<br/>
        "Добавление фирмы" => "Add Company",<br/>
        "Добавление курортов/зон отдыха" => "Adding resorts / recreation",<br/>
        "Добавление гостиницы" => "Add Hotel",
    <hr/>
</form>