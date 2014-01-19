<?php

class FirmsController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogFirmsAdd";
        $this->tableName = "catalog_firms";
        $this->name = "фирмы";
    }

    public function actionTourDelete()
    {
        Yii::app()->page->title = "Запись удалена";
        $message = "";

        $id = (int)Yii::app()->request->getParam("id", 0);
        $tid = (int)Yii::app()->request->getParam("tid", 0);
        if( !empty( $id ) && !empty( $tid ) )
        {

            $tableName = $this->addModel;
            $item = $tableName::fetch( $id );
            if( $item->id && $item->user_id->id == Yii::app()->user->getId() )
            {
                $tourModel = CatalogTours::fetch( $tid );
                if( $tourModel->id >0 && $tourModel->firm_id->id == $item->id )
                {
                    foreach( CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions(" item_id=:itemId AND catalog=:catalog ")
                        ->setParams( array( ":itemId"=>$tourModel->id, ":catalog"=>"catalog_tours" ) ) ) as $galItem )
                        $galItem->delete();

                    $tourModel->delete();

                    if( is_array($tourModel->getErrors()) && sizeof( $tourModel->getErrors() )>0 )
                        print_r( $tourModel->getErrors() );
                }
            }
        }

        $this->actionDescription( );
    }

    public function actionCommentRead()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        if( $id >0 )
        {
            $commentModel = CatalogFirmsCommentsAdd::fetch( $id );
            if( $commentModel->id > 0 && $commentModel->user_id->id == Yii::app()->user->getId() )
            {
                $commentModel->is_new = 0;
                $commentModel->save();

                ?>
                    <td><?= $commentModel->id ?></td>
                    <td>
                        <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$commentModel->id, "fid"=>$item->id)) ?>" title="описание акции/скидки"><?= $commentModel->name ?></a><br/>
                        <?= SiteHelper::getSubTextOnWorld( $commentModel->description, 450 ) ?>
                    </td>
                    <td class="textAlignCenter"><?= SiteHelper::getDateOnFormat( $commentModel->date, "d.m.Y H:i" ) ?></td>
                    <td class="textAlignCenter"><?= ( $commentModel->is_new == 1 ) ? "новое<br/>" : "" ?><?= ( $commentModel->active == 1 ) ? "опубликовано" : "не опубликованно" ?></td>
                    <td class="textAlignCenter">
                        <a href="#" class="aAction"></a>
                        <div class="itemAction textAlignCenter">
                            <a href="<?= SiteHelper::createUrl("/user/firmService/description", array("id"=>$commentModel->id, "fid"=>$item->id)) ?>">Описание</a><br/>
                            <?php if( $commentModel->is_new == 1 ) : ?>
                                <a href="#" onclick="$(this.parentNode.parentNode.parentNode).load('<?= Yii::app()->params["baseUrl"].SiteHelper::createUrl("/user/firms/commentRead", array("id"=>$commentModel->id)) ?>');">прочитанное</a><br/>
                            <?php endif; ?>
                            <?php if( $commentModel->active == 1 ) : ?>
                                <a href="<?= SiteHelper::createUrl("/user/firmService/nopublish", array("id"=>$commentModel->id, "fid"=>$item->id)) ?>">Снять с публикации</a><br/>
                            <?php else : ?>
                                <a href="<?= SiteHelper::createUrl("/user/firmService/publish", array("id"=>$commentModel->id, "fid"=>$item->id)) ?>">Опубликовать</a><br/>
                            <?php endif; ?>

                            <div class="popup PMarginLeft">
                                <br/>
                                <b>Вы действительно хотите удалить запись?</b>
                                <br/><br/>
                                <a href="#" class="PCancel">Отмена</a>&nbsp;|&nbsp;
                                <a href="<?= SiteHelper::createUrl("/user/firms/serviceDelete", array("id"=>$item->id, "tid"=>$commentModel->id)) ?>">Удалить</a>
                            </div>
                            <a href="#" class="PDel">Удалить</a>
                        </div>
                    </td>
                <?php
            }
        }
    }
}
