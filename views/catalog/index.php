<?php

use app\models\Product;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\CatalogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог товаров';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h3><?= Html::encode($this->title) ?></h3>


    <?php Pjax::begin(); ?>
    <?php # $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        // public $layout = "{summary}\n{items}\n{pager}";
        "layout" => "{summary}\n<div class=\"d-flex flex-wrap gap-3 justify-content-center justify-content-md-between \">{items}</div>\n{pager}",
        "pager" => [
            "class" => LinkPager::class,
        ],
        'itemView' => 'item',
    ]) ?>

    <?php Pjax::end(); ?>

</div>