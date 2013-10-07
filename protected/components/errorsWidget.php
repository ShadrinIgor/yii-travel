<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода ошибок в HTML пормате
 */
class errorsWidget extends CWidget
{
    public $errors;
    public function run()
    {
        $this->render("errors", array(
                    'errors' => $this->errors
        ));
    }
}
