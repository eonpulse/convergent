<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Общение c '.$userto['username'];
//var_dump($userto);
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php foreach ($messages as $message): ?>
    <li>
        <?= ($userid == $message['userto'] ? '[Исходящее] ' : '[Входящее] ') ?>
        <?= $message['message'] ?></li>
<?php endforeach; ?>


