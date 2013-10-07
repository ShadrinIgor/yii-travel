<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $this->renderPartial('//layouts/header'); ?>
</head>
<body>
<!-- facebook like -->
<div id="fb-root"></div>
<!-- end of facebook like -->

<div id="BMain">
    <div id="Main">
        <div id="Mcenter">
            <?php $this->renderPartial('//layouts/header_2'); ?>
        </div>
        <?= SiteHelper::renderDinamicPartial("rightColumn"); ?>
        <?php echo $content; ?>
    </div>
    <?php $this->renderPartial('//layouts/footer'); ?>
</div>
</body>