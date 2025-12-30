<?php

use yii\bootstrap5\Html;
?>
<div class="card mb-3">
    <div class="card-body">

        <h5 class="card-titl    e"><?= $model->product->title ?></h5>
        <div class="card-text d-flex justify-content-between align-items-end ">
            <?= Html::img("/img/" . $model->product->productImages[0]->photo, ["style" => "width: 150px;"]) ?>

        </div>
        <div class="d-flex justify-content-end gap-5 align-items-end ">

            <div>

                Стоимость: <span class="fw-semibold fs-3 text-secondary"><?= $model->price ?></span><span class="fw-normal fs-5 ">&#8381;</span>

            </div>
            <div>
                Кол-во: <span class=" fs-3"><?= $model->amount ?></span>
            </div>
            <div>
                Сумма: <span class="fs-3 fw-semibold "><?= $model->total ?></span><span class="fw-normal fs-5">&#8381;</span>
            </div>

        </div>
    </div>
</div>