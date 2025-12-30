<?php

use app\models\PayType;
use app\models\Status;
use yii\widgets\DetailView;
use yii\widgets\ListView;



?>
<?= "Статус заказа №" . $model->id . " от " . Yii::$app->formatter->asDatetime($model->created_at, "php:d.m.Y H:i:s"); ?>
<p>
    сменился на: <?= Status::getStatus($model->status_id) ?>
</p>