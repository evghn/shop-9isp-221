<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Состав корзины';

?>
<div class="cart-index">

    <h4 class="mb-5"><?= Html::encode($this->title) ?></h4>

    <?php Pjax::begin([
        "id" => "cart-pjax",
        "enablePushState" => false,
        "timeout" => 5000,
    ]); ?>

    <?php if ($dataProvider->totalCount): ?>

        <div class="fs-3 mb-2">
            Общее количество товаров в корзине: <?= $cart->amount ?> на сумму: <?= $cart->total ?><span class="fw-normal fs-5 ">&#8381;</span>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => "item",
            "layout" => "{items}\n{pager}",

            "pager" => [
                "class" => LinkPager::class,
            ]
        ]) ?>
    <?php else: ?>
        <div class="alert alert-primary" role="alert">
            Товары в корзине отсуствуют!
        </div>
    <?php endif ?>

    <?php Pjax::end(); ?>

</div>
<?php
$this->registerJsFile("/js/cart.js", ["depends" => JqueryAsset::class]);
