<?php

use app\models\Course;
use app\models\PayType;
use app\models\Status;
use yii\bootstrap5\Html;


switch (Status::getStatusAlias($model->status_id)) {
    case "new":
        $color_status = "bg-success-subtle";
        break;
    case "study":
        $color_status = "status-study";
        break;
    case "final":
        $color_status = "bg-primary-subtle";
        break;
    case "cancel":
        $color_status = "bg-warning-subtle";
        break;

    case "in-working":
        $color_status = "bg-info-subtle";
        break;
}

// var_dump($model->status_id, Status::getStatusAlias($model->status_id), $color_status);
// die;


?>
<div class="card my-3">
    <h5 class="card-header"><?= "Заказ №" . $model->id . ' от ' . Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?></h5>
    <div class="card-body">

        <div class="d-flex flex-column justify-content-start gap-1 align-items-start mb-2 ">
            <div>
                Кол-во товаров: <span class=" fs-3"><?= $model->amount ?></span>
            </div>
            <div>
                Сумма: <span class="fs-3 fw-semibold "><?= $model->total ?></span><span class="fw-normal fs-5">&#8381;</span>
            </div>

        </div>
        <div class="d-flex align-items-start gap-2 mb-2">
            <div class="text-secondary fs-5">
                Тип оплаты:
            </div>
            <div class="fs-5">
                <?= PayType::getPayTypes()[$model->pay_type_id] ?>
            </div>
        </div>

        <div class="d-flex align-items-baseline gap-2">
            <div class="text-secondary fs-5">
                Статус:
            </div>
            <div class="fs-5 <?= $color_status ?> px-3 py-1 rounded-2">

                <?= Status::getStatus($model->status_id) ?>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4 mt-md-2 gap-3">
            <?= $model->status_id === Status::getStatusId('final')
                ? Html::a('Написать отзыв', ['feedback', 'id' => $model->id], ['class' => 'btn btn-outline-primary'])
                : ''
            ?>
            <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-info']) ?>
        </div>


    </div>
</div>