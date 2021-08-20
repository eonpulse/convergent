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
        <?= $message['messagetext'] ?></li>
<?php endforeach; ?>


<?php $form = ActiveForm::begin([
    'id' => 'message-form',
    'layout' => 'horizontal',
]); ?>
<br>
<?= $form->field($model, 'messagetext')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'userto')->hiddenInput(['value' => $userid]) ?>

<div class="form-group">
    <div class="offset-lg-1 col-lg-11">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
