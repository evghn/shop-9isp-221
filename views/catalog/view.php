<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p class="mt-3">
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-info']) ?>
    </p>

    <div class="d-flex flex-wrap  gap-5">
        <?= Html::img("/img/{$model->productImages[0]->photo}", ["class" => "w-25"]) ?>
        <div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'title',
                    'amount',
                    'price',
                    [
                        "attribute" => 'category_id',
                        "value" => $model->category->title,

                    ],
                    [
                        "attribute" => 'description',
                        "format" => "html",
                    ],
                ],
            ]) ?>

        </div>
    </div>

</div>