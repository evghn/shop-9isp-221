<?php

use yii\bootstrap5\Html;
?>

<div class="card m-auto" style="max-width: 18rem;">

    <?= Html::a(Html::img("/img/{$model->product->productImages[0]->photo}", ["class" => "w-100"]), ["view", "id" => $model->product->id]) ?>
    <div class="card-body">
        <h5 class="card-title fs-4"><?= Html::a($model->product->title, ["view", "id" => $model->product->id], ["class" => "text-decoration-none"]) ?></h5>
        <div class="card-text ">
            <div>
                <span class="text-secondary">Категория: </span><span class=""><?= $model->product->category->title ?></span>
            </div>

            <div class="d-flex justify-content-end fw-semibold fs-3 align-items-baseline">
                <?= $model->product->price ?><span class="fw-normal fs-5">&#8381;</span>
            </div>

        </div>
        <div class="d-flex justify-content-between">
            <div></div>
            <div>
                <?= Yii::$app->user?->identity?->isClient
                    ? Html::a(
                        !empty($model->status)
                            ? "💗"
                            : "🤍",
                        ["change", "product_id" => $model->product->id],
                        ['class' => "text-decoration-none btn-favourite"]
                    )
                    : ""
                ?>
            </div>
        </div>

        <?/* !Yii::$app->user->isGuest && Yii::$app->user->identity->isClient
            ? Html::a("В корзину", [""], ['class' => "btn btn-outline-primary w-100  fs-5 py-2 mt-3"])
            : ""
            */
        ?>


    </div>
</div>