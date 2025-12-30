<?php

use app\models\PayType;
use app\models\Status;

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = "Заказ №" . $model->id . " от " . Yii::$app->formatter->asDatetime($model->created_at, "php:d.m.Y H:i:s");
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a("Назад", ['index'], ["class" => "btn btn-outline-info"]) ?>
        <?php if ($model->status_id == Status::getStatusId('new')): ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'amount',
            'total',
            [
                "attribute" => 'status_id',
                "value" => Status::getStatus($model->status_id)
            ],
            [
                "attribute" => 'pay_type_id',
                "value" => PayType::getPayType($model->pay_type_id)
            ],
            [
                "label" => "Состав заказа",
                "format" => "html",
                "value" => function ($model) use ($dataProvider) {

                    return ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => "item-order",
                        "layout" => "{items}\n{pager}",

                    ]);
                }
            ]
        ],
    ]) ?>

</div>