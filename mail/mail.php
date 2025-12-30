<?php

use app\models\PayType;
use app\models\Status;
use yii\widgets\DetailView;
use yii\widgets\ListView;



?>
<?= "Заказ №" . $model->id . " от " . Yii::$app->formatter->asDatetime($model->created_at, "php:d.m.Y H:i:s"); ?>

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
                        'itemView' => "@app/modules/account/views/account-order/item-order",
                        "layout" => "{items}\n{pager}",

                    ]);
                }
            ]
        ],
    ]) ?>
