<?php

use yii\bootstrap5\Html;
?>
<div class="card mb-3">
    <div class="card-body">

        <h5 class="card-title"><?= $model->product->title ?></h5>
        <div class="card-text d-flex justify-content-between align-items-end ">
            <?= Html::img("/img/" . $model->product->productImages[0]->photo, ["style" => "width: 150px;"]) ?>
            <div class="d-flex justify-content-end fw-semibold fs-3 align-items-baseline text-secondary">
                <?= $model->price ?><span class="fw-normal fs-5 ">&#8381;</span>
            </div>

        </div>
        <div class="d-flex mt-3 justify-content-end gap-5 align-items-end ">
            <div class="d-flex mt-3 gap-3 align-items-center ">
                <?= Html::a("➖", ["/account/cart/change-item", "item_id" => $model->id, "action" => "minus"], ['class' => "text-decoration-none btn-cart-item_action", "data-pjax" => 0]) ?>
                <span class=" fs-3"><?= $model->amount ?></span>
                <?= Html::a("➕", ["/account/cart/change-item", "item_id" => $model->id], ['class' => "text-decoration-none btn-cart-item_action", "data-pjax" => 0]) ?>


            </div>
            <div class="fs-3 fw-semibold ">
                <?= $model->total ?><span class="fw-normal fs-5">&#8381;</span>
            </div>

            <div class="align-items-start" style="min-height: 100%;">
                <?= Html::a("🗑", ["/account/cart/remove-item", "id" => $model->id], ['class' => "text-decoration-none btn-cart-item-remove text-danger", "data-pjax" => 0]) ?>
            </div>
        </div>
    </div>
</div>