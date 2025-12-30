<?php

use app\models\PayType;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = 'Создание заказа';
?>
<div class="cart-index">

    <h4 class="mb-5"><?= Html::encode($this->title) ?></h4>
    <div class="fs-3 mb-2">
        Общее количество товаров в заказе: <?= $cart->amount ?> на сумму: <?= $cart->total ?><span class="fw-normal fs-5 ">&#8381;</span>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => "item-create",
        "layout" => "{items}\n{pager}",

        "pager" => [
            "class" => LinkPager::class,
        ]
    ]) ?>
    <?php $form = ActiveForm::begin() ?>
    <div class="mt-3 justify-content-between d-flex ">
        <div>
            <?= $form->field($model, 'pay_type_id')->dropDownList(PayType::getPayTypes(), ["prompt" => "Выберете тип оплаты"])  ?>
        </div>
        <div>
            <?= Html::submitButton("Создать заказ", ["class" => "btn btn-outline-primary"]) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>


</div>