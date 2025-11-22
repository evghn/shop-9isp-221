<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление товарами';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p class="mt-5">
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-outline-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                "attribute" => 'title',
                "format" => "html",
                "value" => fn($model) =>
                "<div class='d-flex gap-3'>"
                    . Html::img("/img/{$model->productImages[0]->photo}", ["class" => "w-25"])
                    . $model->title
                    . "</div>",

            ],

            'amount',
            'price',
            [
                "attribute" => 'category_id',
                "value" => fn($model) => $model->category->title,

            ],
            //'description:ntext',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>