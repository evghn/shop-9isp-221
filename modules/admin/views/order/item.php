<?php

use app\models\Course;
use app\models\PayType;
use app\models\Status;
use yii\bootstrap5\Html;


switch (Status::getStatusAlias($model->status_id)) {
    case "new":
        $color_status = "bg-success-subtle";
        break;
    case "in-working":
        $color_status = "bg-primary-subtle";
        break;
    case "final":
        $color_status = "bg-primary-subtle";
        break;
    case "cancel":
        $color_status = "bg-warning-subtle";
        break;
}



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
            <?= $model->status_id === Status::getStatusId('new')
                ? Html::a('Удалить заказ', ['delete', 'id' => $model->id, 'status' => 'delete'], ['class' => 'btn btn-outline-danger', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>
            <?= $model->status_id === Status::getStatusId('new')
                ? Html::a('Принять в работу', ['change-status', 'id' => $model->id, 'status' => 'in-working'], ['class' => 'btn btn-outline-primary', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>



            <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-info']) ?>

        </div>


    </div>
</div>