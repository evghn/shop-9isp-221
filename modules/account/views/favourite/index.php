<?php

use app\models\Favourite;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Избранное (любимые товары)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favourite-index">

    <h3><?= Html::encode($this->title) ?></h3>



    <?php Pjax::begin([
        "id" => "favourite-pjax",
        "enablePushState" => false,
        "timeout" => 5000,
    ]); ?>
    <?php # <?php echo $this->render('_search', ['model' => $searchModel]);    
    ?>
    <?php if ($dataProvider->totalCount): ?>
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
    <?php else: ?>
        <div class="alert alert-primary" role="alert">
            Любимые товары не найдены!
        </div>


    <?php endif ?>

    <?php Pjax::end(); ?>

</div>

<?php
$this->registerJsFile("/js/favourite.js", ["depends" => JqueryAsset::class]);
