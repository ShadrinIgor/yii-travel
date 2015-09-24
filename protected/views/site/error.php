<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="pageError">
    <div>
        <h2>УПС <?= $code; ?>... К сожалению данная страница не найдена</h2>
        <div class="panel panel-danger">
            <div class="panel-heading textAlignCenter">
                <?php echo CHtml::encode($message); ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Вимание!!!</div>
    <div class="panel-body">
        <?= Yii::t("page", "Если произошла непонятная/некорректная ошибка напишите в техническую поддержку, мы обязательно Вам поможем"); ?> - <a href="mailto:<?= Yii::app()->params["supportEmail"] ?>"><?= Yii::app()->params["supportEmail"] ?></a>.<br/>
        <?= Yii::t("page", "P.S. При обращении обязательно укажите адрес страницы и условия при которых произошла ошибка."); ?>
    </div>
</div>
<?php if( sizeof( $list ) >0 ) : ?>
    <?php if( $this->beginCache($link."_error-page".Yii::app()->getLanguage(), array('duration'=>3600*12) ) ) : ?>
    <div class="ListTours">
    <h2>Смотрите также</h2>
    <?php $i=0;foreach( $list as $line ) :
        $i++;
        if( $i==11 )break;

        if( $line->image )
            $image = $line->image;
        else
        {
            $images = ImageHelper::getImages( $line, 1 );
            if( sizeof( $images ) >0 )$image = $images[0]->image;
        }

        if( empty( $image ) )
        {
            $i--;
            continue;
        }

    ?>
        <div class="LTItem">
            <div class="LTImag LTI2"><a href="<?= SiteHelper::createUrl("/".$link."/description" )."/".$line["slug"] ?>.html" title="<?= $line["name"] ?>"><?php if( !empty( $image ) ) : ?><img src="<?= ImageHelper::getImage( $image, 2 ) ?>" alt="<?= $line["name"] ?>" /><?php endif; ?></a></div>
            <div class="LTPrice">
                <span><a href="<?= SiteHelper::createUrl("/".$link."/description" )."/".$line["slug"] ?>.html" title="<?= $line["name"] ?>"><?= $line["name"] ?></a></span>
                <div class="displayNone">
                    <div class="LTText"><a href="<?= SiteHelper::createUrl("/".$link."/description" )."/".$line["slug"] ?>.html" title="<?= $line["name"] ?>"><?= SiteHelper::getSubTextOnWorld( $line["description"], 600 ) ?></a></div>
                    <div class="textAlignRight"><a href="<?= SiteHelper::createUrl("/".$link."/description" )."/".$line["slug"] ?>.html" title="<?= $line["name"] ?>">подробнее >>></a></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <br/><br/>
    <?php $this->endCache();
    endif; ?>
<?php endif; ?>