<?php

use yii\bootstrap5\Html;
?>
<div class="admin-default-index">
    <h3>Панель администратора</h3>
    <div class="mt-5">
        <?= Html::a("Управление категориями", ['/admin/category'], ['class' => "btn btn-outline-primary"]) ?>
        <?= Html::a("Управление товарами", ['/admin/product'], ['class' => "btn btn-outline-success"]) ?>

    </div>
</div>