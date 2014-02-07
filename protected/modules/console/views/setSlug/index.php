<h1>Выставление Slug</h1>
<form action="" method="post">
    Каталог: <input type="text" name="satalog" />&nbsp;
    <input type="submit" name="submit_slug" value="Выставить Slug" />
</form>

<?php if( sizeof( $items )>0 ) : ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <?php if( property_exists( $items[0], "owner" ) ) : ?><th>Owner</th><?php endif; ?>
        </tr>

    <?php foreach( $items as $item ) : ?>
        <tr>
            <td><?= $item->id ?></td>
            <td><?= $item->name ?></td>
            <td><?= $item->slug ?></td>
            <?php if( property_exists( $item, "owner" ) ) : ?>
                <td><?= $item->owner->name ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>