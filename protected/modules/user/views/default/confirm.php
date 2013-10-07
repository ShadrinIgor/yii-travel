<div id="catalogItems">
    <h1>Подтверждение регистрации</h1>
    <?php if( !$error ) : ?>
        <div class="messageSummary">
            <p>
                <b>Поздравляем</b>
                Вы успешно зарегистрировались, авторизуйтесь используя указанные данные.
            </p>
        </div>
    <?php else : ?>
    <div class="errorSummary">
        <p>
            <b>Ошибка</b>
            <ul><li>Вы перешли по не рабочей ссылке.</li></ul>
            <?= !empty( $errorMessage ) ? $errorMessage : "" ?>
        </p>
    </div>
    <?php endif; ?>
</div>