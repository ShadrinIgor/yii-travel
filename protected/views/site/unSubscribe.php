<?php
$this->widget('addressLineWidget', array(
    'links'=>array(
        'отписка от рассылки'
    )
));
?>

<h1>Отписка от рассылки</h1>
<center>
    Ваш Email успешно отключен от рассылки.
</center>
<?php $this->widget( "formNoteWidget", array( "type"=>"infoErrorNote" ) ); ?>