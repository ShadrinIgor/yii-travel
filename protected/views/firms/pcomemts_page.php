<h2>Коментарии и отзывы</h2>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php
    $listComments = CatalogFirmsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id=:firm_id AND active=1")->setParams( array( ":firm_id"=>$item->id ) )->setLimit(50)->setCache(0));
    foreach( $listComments as $comment ): ?>
        <tr <?= $comment->hot==1 ? 'class="isHot"' : "" ?>>
            <td><?= $comment->id ?><br/><?= SiteHelper::getDateOnFormat( $comment->date, "d.m.Y" ) ?></td>
            <td class="textAlignJustify">
                <a href="#" class="commentHref" title=""><?= $comment->name ?></a><br/>
                <div class="commentLText">
                    <?= SiteHelper::getSubTextOnWorld( $comment->description, 400 ) ?>
                </div>
                <div class="commentText displayNone">
                    <?= $comment->description ?>
                </div>
                <div class="itemAction textAlignRight">
                    <a href="#" class="commentHref">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $listTours ) == 0 ) : ?>
        <tr>
            <td colspan="5" class="textAlignCenter emptyList">Список пуст</td>
        </tr>
    <?php endif; ?>
</table>
<div class="textAlignCenter">
    <p><a href="#" id="commentdAdd" class="openDisplay">[ отправить сообщение ]</a></p>
</div>
<div id="commentdAdd_display" class="displayNone">
    <form action="" method="post">
        <?= $commentModel->getMessage(); ?>
        <?= CHtml::errorSummary($commentModel); ?>
        <table class="tableForm">
            <?= CCmodelHelper::addForm( $commentModel, true, $this ) ?>
            <tr>
                <td></td>
                <td >
                    <input type="submit" name="cansel" id="commentdAdd" class="openDisplay" value="Отмена" />&nbsp;
                    <input type="submit" name="send_comment" value="Отправить" />
                </td>
            </tr>
        </table>
    </form>
</div>