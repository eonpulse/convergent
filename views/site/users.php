<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Список пользователей';
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php foreach ($userlist as $user): ?>
    <li><a href="<?= yii\helpers\Url::to(['site/message/'.$user->id]) ?>"><?= $user->username ?></a></li>
<?php endforeach; ?>