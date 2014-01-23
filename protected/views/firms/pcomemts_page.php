<h2>Коментарии и отзывы</h2>
<?= $commentModel->getMessage(); ?>
<table id="tableListItems" cellpadding="0" cellspacing="0">
    <tr>
        <th class="TLFId">№</th>
        <th class="TLFAction">Краткое описание</th>
    </tr>
    <?php
    foreach( $items as $comment ): ?>
        <tr <?= $comment->hot==1 ? 'class="isHot"' : "" ?>>
            <td>#<?= $comment->id ?><br/><?= SiteHelper::getDateOnFormat( $comment->date, "d.m.Y" ) ?></td>
            <td class="textAlignJustify">
                <a href="#" class="commentHref" title=""><?= $comment->name ?></a><br/>
                <div class="commentLText">
                    <?= SiteHelper::getSubTextOnWorld( $comment->description, 400 ) ?>
                </div>
                <div class="commentText overflowHidden displayNone">
                    <?= $comment->description ?>
                </div>
                <div class="itemAction textAlignRight">
                    <a href="#" class="commentHref">Описание</a><br/>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if( sizeof( $items ) == 0 ) : ?>
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