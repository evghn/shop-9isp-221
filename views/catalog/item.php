<?php

use yii\bootstrap5\Html;
?>

<div class="card m-auto" style="max-width: 18rem;">

    <?= Html::a(Html::img("/img/{$model->productImages[0]->photo}", ["class" => "w-100"]), ["view", "id" => $model->id]) ?>
    <div class="card-body">
        <h5 class="card-title fs-4"><?= Html::a($model->title, ["view", "id" => $model->id], ["class" => "text-decoration-none"]) ?></h5>
        <div class="card-text ">
            <div>
                <span class="text-secondary">Категория: </span><span class=""><?= $model->category->title ?></span>
            </div>

            <div class="d-flex justify-content-end fw-semibold fs-3 align-items-baseline">
                <?= $model->price ?><span class="fw-normal fs-5">&#8381;</span>
            </div>

        </div>
        <div class="d-flex justify-content-between">
            <div>
                <?= Html::a(
                    "👍🏻" . "<span> $model->like</span>",
                    ["/account/favourite/like-change", "product_id" => $model->id, "reaction" => 1],
                    ['class' => "text-decoration-none btn-like"]
                )
                ?>
                <?= Html::a(
                    "👎🏻" . "<span> $model->dislike</span>",
                    ["/account/favourite/like-change", "product_id" => $model->id, "reaction" => 0],
                    ['class' => "text-decoration-none btn-dislike"]
                )
                ?>
            </div>
            <div>
                <?= Yii::$app->user?->identity?->isClient
                    ? Html::a(
                        !empty($model?->favourites[0]->status)
                            ? "💗"
                            : "🤍",
                        ["/account/favourite/change", "product_id" => $model->id],
                        ['class' => "text-decoration-none btn-favourite"]
                    )
                    : ""
                ?>
            </div>
        </div>

        <?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isClient
            ? Html::a("В корзину", ["/account/cart/add", "product_id" => $model->id], ['class' => "btn btn-outline-primary w-100  fs-5 py-2 mt-3 btn-add-cart"])
            : ""
        ?>


    </div>
</div>