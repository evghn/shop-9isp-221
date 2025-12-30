<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h3>Панель администратора</h3>
    <div class="mt-5">
        <?= Html::a("Управление категориями", ['/admin/category'], ['class' => "btn btn-outline-primary"]) ?>
        <?= Html::a("Управление товарами", ['/admin/product'], ['class' => "btn btn-outline-success"]) ?>

    </div>

    <?php Pjax::begin(); ?>
    <div class="d-flex  align-items-baseline flex-wrap gap-3 justify-content-between">
        <div class="d-flex gap-3 ">
            <div>
                Сортировка:
            </div>
            <?= $dataProvider->sort->link('created_at') ?> |
            <?= $dataProvider->sort->link('total') ?>
        </div>
        <div class="d-flex align-items-baseline gap-2 flex-wrap">
            <div>
                Фильтр:
            </div>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
    ]) ?>

    <?php Pjax::end(); ?>

</div>