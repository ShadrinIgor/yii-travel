<form action="index.php" method="post">
    <?php if( !empty( $error ) ) : ?>
        <font style="color:#ff0000"><?= $error ?></font>
    <?php endif; ?>
    <table align="center">
        <tr>
            <th>Логин:</th>
            <td><input type="text" name="login" value="<?= !empty($_POST["login"]) ? $_POST["login"] : "" ?>" /></td>
        </tr>
        <tr>
            <th>Пароль:</th>
            <td><input type="password" name="password" /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input type="submit" name="submit_ok" value="Зайти" /></td>
        </tr>
    </table>
</form>